<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Survey;
use App\Form\Type\SurveyType;
use App\Service\FormErrorService;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="Survey")
 */
class SurveyController extends AbstractFOSRestController
{
    public function __construct(EntityManagerInterface $entityManager, FormErrorService $formErrorService)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Survey::class);
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
     *     description="ID of requested survey"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Survey found",
     *     @Model(type=Survey::class)
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Survey not found",
     * )
     */
    public function getSurvey(int $id): object
    {
        $survey = $this->repository->findOneBy(['id' => $id]);

        if (!$survey) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($survey, Response::HTTP_OK));
    }

    /**
     * @return Response
     * 
     * @SWG\Response(
     *     response=200,
     *     description="Surveys found",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#definitions/Survey")
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Surveys not found",
     * )
     */
    public function getSurveys()
    {
        $surveys = $this->repository->findAll();

        if (!$surveys) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        return $this->handleView($this->view($surveys, Response::HTTP_OK));
    }

    /**
     * @param Request $request
     * @return Response
     * 
     * @SWG\Parameter(
     *     name="Survey",
     *     in="body",
     *     required=true,
     *     description="Survey object",
     *     @Model(type=Survey::class)
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Survey created",
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
    public function postSurvey(Request $request)
    {        
        $survey = new Survey();
        $form = $this->createForm(SurveyType::class, $survey);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($survey);
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
     *     name="Survey",
     *     in="body",
     *     required=true,
     *     description="Survey object",
     *     @Model(type=Survey::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="ID of survey to update"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Survey updated",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.updated"}
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Survey not found",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request",
     * ) 
     */
    public function patchSurvey(Request $request, int $id)
    {
        $data = $request->request->all();
        $survey = $this->repository->find($id);

        if (!$survey) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $form = $this->createForm(SurveyType::class, $survey);
        $form->submit($data, false);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($survey);
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
     *     description="ID of survey to delete"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Survey deleted",
     *     @SWG\Schema(
     *         type="string",
     *         example={"response.deleted"}
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="Survey not found",
     * )
     */
    public function deleteSurvey(int $id)
    {
        $survey = $this->repository->findOneById($id);

        if (!$survey) {
            return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
        }

        $this->em->remove($survey);
        $this->em->flush();

        return $this->handleView(
            $this->view('request.deleted', Response::HTTP_OK)
        );
    }
}
