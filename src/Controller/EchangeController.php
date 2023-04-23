<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Transporteur;
use App\Entity\Echange;
use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse; 
use TCPDF;

class EchangeController extends AbstractController
{
    #[Route('/echange')]
    #[Route('/echange', name: 'app_echange', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $transporteurs = $entityManager->getRepository(Transporteur::class)->findAll();

        $echanges = $entityManager
            ->getRepository(Echange::class)
            ->findAll();

        return $this->render('echange/index.html.twig', [
            'echanges' => $echanges,
            'transporteurs' => $transporteurs,
        ]);
    }

    /**
     * @Route("/echange/generer-facture/{id}", name="generer_facture")
     */
    public function genererFacture(Echange $echange): Response
    {
        // Generate PDF invoice for the specified Echange entity
        $pdfContent = $this->generatePdfInvoice($echange);
        
        // Return the PDF file as a response
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="facture-echange-'.$echange->getId().'.pdf"',
        ]);
    }
    
    
    /**
     * Generate a PDF invoice for the specified Echange entity.
     */
  

private function generatePdfInvoice(Echange $echange): string
{
    // Create a new TCPDF object
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->setFont('helvetica', '', 25); // set font and font size
    $pdf->SetMargins(0,0,0); // set margins to 0
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Facture d\'échange n° '.$echange->getId());
    $pdf->SetSubject('Facture d\'échange n° '.$echange->getId());
    $pdf->SetTextColor(0, 0, 0); // set the color back to black
    
    // Add a new page
    $pdf->AddPage();
    
    // Set the header and footer
    $pdf->setHeaderData('', 0, 'Facture d\'échange n° '.$echange->getId(), 'Générée le '.date('d/m/Y H:i:s'), array(0,0,0), array(255,255,255));
    $pdf->setFooterData(array(0,0,0), array(255,255,255));
    
    // Write the company information in center
    $pdf->SetXY(0, 80);
    $pdf->Write(5, "Tunitroc", '', 0, 'C');
    $pdf->setFont('helvetica', '', 14);
    $pdf->SetXY(0, 90);
    $pdf->Write(5, "123 Rue des Exchanges", '', 0, 'C');
    $pdf->SetXY(0, 100);
    $pdf->Write(5, "75001 Paris, France", '', 0, 'C');
    $pdf->Ln(10);
    
    // Write the client information in red color
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Write(5, "Client:\n");
    $pdf->Write(5, "Aziz \n");
    $pdf->Write(5, "Nacib \n");
    $pdf->SetTextColor(0, 0, 0); // set the color back to black
    
    // Write the exchange details
    $pdf->Write(5, "\nDétails de l'échange:\n\n");
    $pdf->setFont('helvetica', '', 16);
    $pdf->Write(5, "Numéro d'échange: ".$echange->getId()."\n\n");
    $pdf->Write(5, "Date de création: ".$echange->getCreatedAt()->format('d/m/Y H:i:s')."\n\n");
    $pdf->Write(5, "Etat de l'échange: ".$echange->getEtat()."\n\n");
    $pdf->Write(5, "Lieu de l'échange: ".$echange->getLocation()."\n\n");
    $pdf->Ln(10);
    
    // Write the product details in green color
    $pdf->SetTextColor(0, 128, 0);
    $pdf->Write(5, "Produits échangés:\n\n");
    $pdf->setFont('helvetica', '', 14);
    $pdf->Write(5, $echange->getIdPanier()->getProduitR()->getNom()."\n");
    $pdf->Write(5, $echange->getIdPanier()->getProduitS()->getNom()."\n\n");
    $pdf->SetTextColor(0, 0, 0); // set the color back to black
    
    $pdf->setFont('helvetica', '', 16);
    $pdf->Write(5, "Merci de votre confiance et à bientôt sur Tunitroc !");
    
    // Return the generated PDF as a string
    return $pdf->Output('Facture_echange_'.$echange->getId().'.pdf', 'S');
}

   /**
 * @Route("/echange/confirmer/{id}", name="confirmer_echange")
 */ 
public function confirmerEchange($id, ManagerRegistry $doctrine)
{
    // Get the Echange entity from the database
    $echange = $doctrine->getRepository(Echange::class)->find($id);

    // Check if the Echange entity exists
    if (!$echange) {
        throw $this->createNotFoundException('Echange not found with id '.$id);
    }

    // Update the status of the Echange to "confirmed"
    $echange->setEtat('confirmed');
    $em = $doctrine->getManager();
    $em->flush();

    // Create a response to indicate success
    $response = new JsonResponse();
    $response->setData([
        'message' => 'Echange with id '.$id.' has been confirmed.'
    ]);

    // Set the alert message and type
    $response->headers->set('X-Alert-Message', 'Echange confirmed!');
    $response->headers->set('X-Alert-Type', 'success');

    return $response;
}


}
