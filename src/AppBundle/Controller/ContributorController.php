<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contributor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/contributors/show/{id}", name="contributor_show")
     */
    public function showAction(Contributor $contributor)
    {
        return $this->render('contributors/show.html.twig', [
            'contributor' => $contributor
        ]);
    }
}
