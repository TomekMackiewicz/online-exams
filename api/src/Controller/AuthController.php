<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Form\Type\UserType;
use App\Service\FormErrorService;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @SWG\Tag(name="Auth")
 */
class AuthController extends AbstractFOSRestController
{
    public function __construct(EntityManagerInterface $entityManager, FormErrorService $formErrorService) 
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(User::class);
        $this->formErrorService = $formErrorService;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * 
     * @SWG\Parameter(
     *     name="User",
     *     in="body",
     *     required=true,
     *     description="User object",
     *     @Model(type=User::class)
     * )
     * @SWG\Parameter(
     *     name="UserPasswordEncoderInterface",
     *     in="body",
     *     required=true,
     *     description="Password encoder",
     *     @Model(type=UserPasswordEncoderInterface::class)
     * )
     * @SWG\Response(
     *     response=201,
     *     description="User created",
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
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $request->request->get('password');
            $user->setPassword($encoder->encodePassword($user, $password['first']));
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
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
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

}