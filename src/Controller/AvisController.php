<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Avis;
use App\Form\AvisType;
use Doctrine\Persistence\ManagerRegistry;





class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
public function index(): Response
{
    return $this->render('Avis/index.html.twig', [
        'controller_name' => 'AvisController',
    ]);
}
#[Route('/addAvis', name: 'add_avis')]
public function add(Request $request, ManagerRegistry $doctrine): Response
{
    $avis = new Avis();
    $form = $this->createForm(AvisType::class, $avis);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
        $entityManager->persist($avis);
        $entityManager->flush();

        return $this->redirectToRoute('app_avis');
    }

    return $this->render('avis/createAvis.html.twig', ['f' => $form->createView()]);
}

}
