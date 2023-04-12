<?php

namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Transporteur;
use App\Repository\TransporteurRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Echange;
use App\Form\EchangeType;
use App\Repository\EchangeRepository;






class TransportController extends AbstractController
{
   
    #[Route('/transporteur', name: 'app_transporteur')]
public function index(): Response
{
    return $this->render('transporteur/index.html.twig', [
        'controller_name' => 'TransportController',
    ]);
}
 

    #[Route('/transporteur/{id}', name: 'transporteur_show')]
    public function show($id, ManagerRegistry $doctrine, EchangeRepository $echangeRepository) : Response
    {
        $transporteur = $doctrine->getRepository(Transporteur::class)->find($id);

        $livredEchangesCount = $echangeRepository->countEchangesByState('livré');
        $totalAmount = $livredEchangesCount * 7;

        $echanges = $doctrine->getRepository(Echange::class)->findBy(['idTransporteur' => $id]);

        return $this->render('transporteur/show.html.twig', [
            'transporteur' => $transporteur,
            'echanges' => $echanges,
            'totalAmount' => $totalAmount,
            'livredEchangesCount' => $livredEchangesCount,
        ]);
    }
    #[Route('/update/{id}', name: 'update_trechange')]
    public function update(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $echange = $doctrine->getRepository(Echange::class)->find($id);
        $form = $this->createForm(EchangeType::class, $echange);
        $form->add('update', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
            'label_html' => true,
            'label' => 'Update <i class="fas fa-save"></i>'
        ]);
                $form->handleRequest($request);


        $transporteurId = $echange->getIdTransporteur()->getId();
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
    
            return $this->redirectToRoute('transporteur_show', ['id' => $transporteurId]);
        }
    
       
        $transporteur = $doctrine->getRepository(Transporteur::class)->find($transporteurId);

        return $this->renderForm("transporteur/update.html.twig", [
            'form' => $form,
            'transporteur' => $transporteur,
        ]);
    }
    
    #[Route('/delete/{id}', name: 'delete_echange')]
    public function delete(ManagerRegistry $doctrine,$id): Response
    {
        $echange = $doctrine->getRepository(Echange::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($echange);
        $em->flush();
        $transporteurId = $echange->getIdTransporteur()->getId();
        $transporteur = $doctrine->getRepository(Transporteur::class)->find($transporteurId);

            return $this->redirectToRoute('transporteur_show', ['id' => $transporteurId]);
    }
}
