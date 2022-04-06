<?php

namespace App\Controller;

use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidate')]
class CandidateController extends AbstractController
{
    #[Route('/', name: 'app_candidate_profile')]
    #[IsGranted('ROLE_CANDIDATE', message: 'You must be logged-in as a candidate to access this resource')]
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser(); // Returns a Candidate object
        $form = $this->createForm(CandidateType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }

        return $this->renderForm('candidate/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/offers', name: 'app_candidate_offers')]
    #[IsGranted('ROLE_CANDIDATE', message: 'You must be logged-in as a candidate to access this resource')]
    public function offers(Request $request, EntityManagerInterface $em, CandidateRepository $candidateRepository, OfferRepository $offerRepository): Response
    {
        $user = $candidateRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]); // Returns a Candidate object

        // $offers = $offerRepository->findBy(['contractType' => $user->getContractType()]);

        $offers = $offerRepository->findAll();
        $offersFiltered = [];

        foreach ($offers as $offer) {
            foreach ($offer->getCategories() as $category) {
                foreach ($user->getCategories() as $userCategory) {
                    if ($category === $userCategory) {
                        $offersFiltered[] = $offer;
                    }
                }
            }
        }

        // dd(array_unique($offersFiltered));

        return $this->renderForm('candidate/offers.html.twig', [
            'offers' => array_unique($offersFiltered),
        ]);
    }

    #[Route('/applications', name: 'app_candidate_applications')]
    #[IsGranted('ROLE_CANDIDATE', message: 'You must be logged-in as a candidate to access this resource')]
    public function applications(CandidateRepository $candidateRepository): Response
    {
        $user = $candidateRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]); // Returns a Candidate object

        // $offers = $offerRepository->findBy(['contractType' => $user->getContractType()]);

        $offers = $user->getApplications();

        return $this->renderForm('candidate/applications.html.twig', [
            'offers' => $offers,
        ]);
    }
}