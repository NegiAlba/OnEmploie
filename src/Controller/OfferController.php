<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offer')]
class OfferController extends AbstractController
{
    #[Route('/', name: 'app_offer_index')]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'app_offer_details')]
    public function details(Offer $offer): Response
    {
        return $this->render('offer/details.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/create', name: 'app_offer_create')]
    #[IsGranted('ROLE_COMPANY', message: 'You must be logged-in to access this resource')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //? Règles de sécurité : Il faut être un user pour ACCEDER à cette page : DONE
        //? Formulaire à remplir et envoyer : DONE
        //* Formulaire qui va servir à créer des offres d'emploi et les conserver sur la BDD
        //* Afficher le formulaire sur ma page, en prenant soin de le générer automatiquement
        $offer = new Offer();
        $formulaire = $this->createForm(OfferType::class, $offer);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $offer->setAuthor($this->getUser());
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('app_offer_index');
        }

        return $this->renderForm('offer/create.html.twig', ['formulaire' => $formulaire, 'action' => 'Create']);
    }

    #[Route('/edit/{id<\d+>}', name: 'app_offer_edit')]
    #[IsGranted('ROLE_COMPANY', message: 'You must be logged-in to access this resource')]
    public function edit(Offer $offer, Request $request, EntityManagerInterface $em): Response
    {
        //? Vérification d'auteur pour accéder à la page
        if ($this->getUser() === $offer->getAuthor()) {
            $formulaire = $this->createForm(OfferType::class, $offer);
            $formulaire->handleRequest($request);
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $em->flush();

                return $this->redirectToRoute('app_offer_index');
            }

            return $this->renderForm('offer/create.html.twig', ['formulaire' => $formulaire, 'offer' => $offer, 'action' => 'Edit']);
        }

        return $this->redirectToRoute('app_offer_index');
        //? Edition via formulaire prérempli
    }
}