<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Answer;
use App\Form\Type\AnswerType;
use Swagger\Annotations as SWG;

class AnswerController extends AbstractFOSRestController
{
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Answer::class);
    }

    public function getAnswer(int $id): object
    {
        $answer = $this->repository->findOneBy(['id' => $id]);

        if (!$answer) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($answer, Response::HTTP_OK));
    }

    public function getAnswers()
    {
        $answers = $this->repository->findAll();

        if (!$answers) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($answers, Response::HTTP_OK));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postAnswer(Request $request)
    {        
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($answer);
            $this->em->flush();

            return $this->handleView(
                $this->view('ok', Response::HTTP_CREATED)
            );
        }

        return $this->handleView(
            $this->view('error', Response::HTTP_BAD_REQUEST)
        );
    }

    public function patchAnswer(Request $request, int $id)
    {
        $data = $request->request->all();        
        $answer = $this->repository->find($id);

        if (!$answer) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $form = $this->createForm(AnswerType::class, $answer);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($answer);
            $this->em->flush();

            return $this->handleView($this->view('ok', Response::HTTP_NO_CONTENT));
        }
        
        return $this->handleView($this->view('error', Response::HTTP_BAD_REQUEST));        
    }

    public function deleteAnswer(int $id)
    {
        $answer = $this->repository->findOneById($id);

        if (!$answer) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $this->em->remove($answer);
        $this->em->flush();

        return $this->handleView(
            $this->view('ok', Response::HTTP_NO_CONTENT)
        );
    }
}
