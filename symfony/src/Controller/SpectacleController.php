<?php

namespace App\Controller;

use App\Form\SpectacleNewType;
use App\Helper\FormHandler;
use App\Repository\SpectacleRepository;
use App\Service\SpectacleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpectacleController extends AbstractController
{
    /**
     * @Route("/spectacles", name="spectacle_list", methods={"GET"})
     */
    public function index(
        Request $request,
        SpectacleRepository $spectacleRepository
    ): JsonResponse
    {
        return $this->json(
            $spectacleRepository->findAll(),
            JsonResponse::HTTP_OK,
            [],
            ['groups' => 'default']
        );
    }
    /**
     * @Route("/spectacle/new", name="spectacle_new", methods={"POST"})
     */
    public function new(
        Request $request,
        FormHandler $formHandler,
        SpectacleManager $spectacleManager
    ): JsonResponse
    {
        $spectacle = $formHandler->handleForm($request, SpectacleNewType::class);
        $spectacle = $spectacleManager->createSpectacle($spectacle);

        return $this->json(
            $spectacle,
            JsonResponse::HTTP_CREATED,
            [],
            ['groups' => 'default']
        );
    }
}
