<?php

namespace App\Controller;

use App\Form\UserRegisterType;
use App\Helper\FormHandler;
use App\Repository\UserRepository;
use App\Service\UserHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/public/register", name="user", methods={"POST"})
     */
    public function register(
        Request $request,
        FormHandler $formHandler,
        UserRepository $userRepository,
        UserHelper $userHelper
    )
    {
        $server = $request->server;
        $loginUrl = $server->get('REQUEST_SCHEME') . '://' . $server->get('SERVER_NAME') . '/api/login_check';
        $user = $formHandler->handleForm($request, UserRegisterType::class);
        $password = $user->getPassword();

        try {
            $user = $userRepository->register($user);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'username'], 400);
        }

        $data = $userHelper->authenticate($loginUrl, [
            'username' => $user->getUsername(),
            'password' => $password,
        ]);

        return $this->json($data, JsonResponse::HTTP_CREATED);
    }
}
