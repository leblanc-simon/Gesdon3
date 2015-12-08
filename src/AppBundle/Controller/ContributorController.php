<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contributor;
use AppBundle\Entity\Receipt;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContributorController
 * @package AppBundle\Controller
 * @Route("/contributors")
 */
class ContributorController extends Controller
{
    /**
     * @Route("/{page}", name="contributors", defaults={"page" = 1})
     */
    public function indexAction($page)
    {
        $contributors = $this
            ->get('paginator')
            ->setCurrentPage($page)
            ->setQuery($this->get('repository.contributor')->getQueryForAll())
        ;

        return $this->render('contributors/index.html.twig', [
            'contributors' => $contributors
        ]);
    }

    /**
     * @Route("/show/{id}", name="contributor_show")
     */
    public function showAction(Contributor $contributor)
    {
        return $this->render('contributors/show.html.twig', [
            'contributor' => $contributor
        ]);
    }

    /**
     * @Route("/pdf/{id}", name="contributor_pdf")
     */
    public function pdfAction(Receipt $receipt)
    {
        $configuration = $this->get('manager.configuration');

        $header = $this->renderView('receipt/header.html.twig', [
            'receipt' => $receipt,
        ]);

        $footer = $this->renderView('receipt/footer.html.twig', [
            'receiver_name' => $configuration->get('receiver_name'),
            'receiver_subject' => $configuration->get('receiver_subject'),
            'receiver_number' => $configuration->get('receiver_number'),
            'receiver_siret' => $configuration->get('receiver_siret'),
        ]);

        $content = $this->renderView('receipt/content.html.twig', [
            'receiver_name' => $configuration->get('receiver_name'),
            'receiver_subject' => $configuration->get('receiver_subject'),
            'receiver_number' => $configuration->get('receiver_number'),
            'receiver_siret' => $configuration->get('receiver_siret'),
            'receiver_address' => $configuration->get('receiver_address'),
            'receipt' => $receipt,
        ]);

        //return new Response($content);
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $content,
                [
                    'header-html' => $header,
                    'footer-html' => $footer,
                    'margin-left' => '0mm',
                    'margin-right' => '0mm',
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="recu-'.strtolower($receipt->getLegalNumber()).'.pdf"'
            ]
        );
    }
}
