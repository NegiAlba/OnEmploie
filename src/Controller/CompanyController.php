<?php

namespace App\Controller;

use App\Repository\OfferRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company')]
#[IsGranted('ROLE_COMPANY')]
class CompanyController extends AbstractController
{
    #[Route('/offers', name: 'app_company_offers')]
    public function index(OfferRepository $offerRepository): Response
    {
        $user = $this->getUser();
        $offers = $offerRepository->findBy(['author' => $user->getUserId()], ['createdAt' => 'DESC']);

        return $this->render('company/offers.html.twig', [
            'offers' => $offers,
        ]);
    }
}