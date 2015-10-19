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
     * @Route("/", name="contributors")
     */
    public function indexAction()
    {
        $contributors = $this->get('repository.contributor')->findBy([], [
            'lastname' => 'ASC',
            'firstname' => 'ASC',
            'company' => 'ASC',
        ]);
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
