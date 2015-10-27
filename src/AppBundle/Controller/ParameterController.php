<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/configuration", name="parameters_configuration")
     */
    public function configurationAction(Request $request)
    {
        $datas = [
            'configurations' => $this->get('manager.configuration')->getAll()
        ];
        $form = $this->createForm('configuration', $datas);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $this->get('manager.configuration')->saveAll($datas['configurations']);
            return $this->redirectToRoute('parameters');
        }

        return $this->render('parameter/configuration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}