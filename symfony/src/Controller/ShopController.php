<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopSpectaclesType;
use App\Helper\FormHandler;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="shop", methods={"GET"})
     */
    public function index(ShopRepository $shopRepository): JsonResponse
    {
        return $this->json(
            $shopRepository->findAll(),
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['default', 'withOwner']]
        );
    }

    /**
     * @Route("/shops/{id}", name="shop_detail", methods={"GET"})   
     */
    public function detail(Shop $shop): JsonResponse
    {
        return $this->json(
            $shop,
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['default', 'withOwner']]
        );
    }

    /**
     * @Route("/shops/{id}/spectacles", name="shop_spectacles", methods={"POST"})   
     */
    public function shopSpectacles(
        Shop $shop,
        Request $request,
        FormHandler $formHandler,
        ShopRepository $shopRepository
    ): JsonResponse
    {
        $data = $formHandler->handleForm($request, ShopSpectaclesType::class);
        $shopRepository->updateSpectacles($shop, $data['spectacles']);
        
        return $this->json(
            $shop,
            JsonResponse::HTTP_OK,
            [],
            ['groups' => ['default']]
        );
    }
}
