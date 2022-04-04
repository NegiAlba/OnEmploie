<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offer')]
class OfferController extends AbstractController
{
    #[Route('/', name: 'app_offer_index')]
    public function index(): Response
    {
        return $this->render('offer/index.html.twig', [
            'controller_name' => 'OfferController',
        ]);
    }

    #[Route('/create', name: 'app_offer_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //? Formulaire à remplir et envoyer
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

        return $this->renderForm('offer/create.html.twig', ['formulaire' => $formulaire]);

        //? Règles de sécurité : Il faut être un user pour ACCEDER à cette page
    }
}