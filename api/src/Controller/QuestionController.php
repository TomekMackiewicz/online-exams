<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Question;
use App\Form\Type\QuestionType;
use App\Service\FormErrorService;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="Question")
 */
class QuestionController extends AbstractFOSRestController
{
    public function __construct(EntityManagerInterface $entityManager, FormErrorService $formErrorService)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Question::class);
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
     *     description="ID of requested question"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Question found",
     *     @Model(type=Question::class)
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Question not found",
     * )
     */
    public function getQuestion(int $id): object
    {
        $question = $this->repository->findOneBy(['id' => $id]);

        if (!$question) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($question, Response::HTTP_OK));
    }

    /**
     * @return Response
     * 
     * @SWG\Response(
     *     response=200,
     *     description="Questions found",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#definitions/Question")
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Questions not found",
     * )
     */
    public function getQuestions()
    {
        $questions = $this->repository->findAll();

        if (!$questions) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($questions, Response::HTTP_OK));
    }

    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Parameter(
     *     name="Question",
     *     in="body",
     *     required=true,
     *     description="Question object",
     *     @Model(type=Question::class)
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Question created",
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
    public function postQuestion(Request $request)
    {        
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($question);
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
     *     name="Question",
     *     in="body",
     *     required=true,
     *     description="Question object",
     *     @Model(type=Question::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="ID of question to update"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Question updated",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.updated"}
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Question not found",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request",
     * ) 
     */
    public function patchQuestion(Request $request, int $id)
    {
        $data = $request->request->all();
        $question = $this->repository->find($id);

        if (!$question) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $form = $this->createForm(QuestionType::class, $question);
        $form->submit($data, false);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($question);
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
     *     description="ID of question to delete"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Question deleted",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.deleted"}
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Question not found",
     * )
     */
    public function deleteQuestion(int $id)
    {
        $question = $this->repository->findOneById($id);

        if (!$question) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $this->em->remove($question);
        $this->em->flush();

        return $this->handleView(
            $this->view('request.deleted', Response::HTTP_OK)
        );
    }
}
