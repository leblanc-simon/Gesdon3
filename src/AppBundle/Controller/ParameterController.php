<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContributorType;
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contributor_types", name="parameters_contributor_types")
     */
    public function contributorTypesAction()
    {
        return $this->render('parameter/contributor_type/index.html.twig', [
            'contributor_types' => $this->get('repository.contributor_type')->findBy([], [
                'name' => 'ASC',
            ]),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contributor_types/{id}/edit", name="parameters_contributor_types_edit")
     */
    public function contributorTypeEditAction(Request $request, ContributorType $contributor_type)
    {
        return $this->contributorTypeEdit($request, $contributor_type);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contributor_types/add", name="parameters_contributor_types_add")
     */
    public function contributorTypeAddAction(Request $request)
    {
        return $this->contributorTypeEdit($request, new ContributorType());
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contributor_types/{id}/delete", name="parameters_contributor_types_delete")
     */
    public function contributorTypeDeleteAction(Request $request, ContributorType $contributor_type)
    {
        $form = $this->createForm('contributor_type_delete', $contributor_type);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->remove($contributor_type);
            $entity_manager->flush();
            $this->get('session.flash_bag')->add('success', 'item.removed');
            return $this->redirectToRoute('parameters_contributor_types');
        }

        return $this->render('parameter/contributor_type/delete.html.twig', [
            'form' => $form->createView(),
            'contributor_type' => $contributor_type,
        ]);
    }

    private function contributorTypeEdit(Request $request, ContributorType $contributor_type)
    {
        $form = $this->createForm('contributor_type', $contributor_type);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $entity_manger = $this->getDoctrine()->getManager();
            $entity_manger->persist($contributor_type);
            $entity_manger->flush();
            $this->get('session.flash_bag')->add('success', 'item.saved');
            return $this->redirectToRoute('parameters_contributor_types');
        }

        return $this->render('parameter/contributor_type/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}