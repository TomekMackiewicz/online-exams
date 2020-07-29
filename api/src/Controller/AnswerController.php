<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Answer;
use App\Form\Type\AnswerType;
use App\Service\FormErrorService;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="Answer")
 */
class AnswerController extends AbstractFOSRestController
{
    public function __construct(EntityManagerInterface $entityManager, FormErrorService $formErrorService) 
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Answer::class);
        $this->formErrorService = $formErrorService;
    }

    /**
     * @param int $id
     * @return Response
     * 
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="ID of requested answer"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Answer found",
     *     @Model(type=Answer::class)
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Answer not found",
     * )
     */
    public function getAnswer(int $id): object
    {
        $answer = $this->repository->findOneBy(['id' => $id]);

        if (!$answer) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($answer, Response::HTTP_OK));
    }

    /**
     * @return Response
     * 
     * @SWG\Response(
     *     response=200,
     *     description="Answers found",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#definitions/Answer")
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Answers not found",
     * )
     */
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
     * 
     * @SWG\Parameter(
     *     name="Answer",
     *     in="body",
     *     required=true,
     *     description="Answer object",
     *     @Model(type=Answer::class)
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Answer created",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.created"}
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request",
     * )
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
                $this->view('response.created', Response::HTTP_CREATED)
            );
        }
        $errors = $this->formErrorService->prepareErrors($form->getErrors(true));
        
        return $this->handleView(
            $this->view($errors, Response::HTTP_BAD_REQUEST)
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * 
     * @SWG\Parameter(
     *     name="Answer",
     *     in="body",
     *     required=true,
     *     description="Answer object",
     *     @Model(type=Answer::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="ID of answer to update"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Answer updated",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.updated"}
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Answer not found",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request",
     * ) 
     */
    public function patchAnswer(Request $request, int $id)
    {
        $data = $request->request->all();        
        $answer = $this->repository->find($id);

        if (!$answer) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $form = $this->createForm(AnswerType::class, $answer);
        $form->submit($data, false);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($answer);
            $this->em->flush();

            return $this->handleView($this->view('request.updated', Response::HTTP_OK));
        }
        $errors = $this->formErrorService->prepareErrors($form->getErrors(true));

        return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));        
    }

    /**
     * @param int $id
     * @return Response
     * 
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="ID of answer to delete"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Answer deleted",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.deleted"}
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Answer not found",
     * )
     */
    public function deleteAnswer(int $id)
    {
        $answer = $this->repository->findOneById($id);

        if (!$answer) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $this->em->remove($answer);
        $this->em->flush();

        return $this->handleView(
            $this->view('request.deleted', Response::HTTP_OK)
        );
    }
}
