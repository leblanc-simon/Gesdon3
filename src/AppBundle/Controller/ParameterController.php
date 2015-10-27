<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ParameterController
 * @package AppBundle\Controller
 * @Route("/parameters")
 */
class ParameterController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("", name="parameters")
     */
    public function indexAction()
    {
        return $this->render('parameter/index.html.twig');
    }
}