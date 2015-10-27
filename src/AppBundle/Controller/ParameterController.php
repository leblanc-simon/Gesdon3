<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContributorType;
use AppBundle\Entity\PaymentType;
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
     * @Route("/contributor-types", name="parameters_contributor_types")
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
     * @Route("/contributor-types/{id}/edit", name="parameters_contributor_types_edit")
     */
    public function contributorTypeEditAction(Request $request, ContributorType $contributor_type)
    {
        return $this->typeEdit($request, $contributor_type, 'contributor_type');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contributor-types/add", name="parameters_contributor_types_add")
     */
    public function contributorTypeAddAction(Request $request)
    {
        return $this->typeEdit($request, new ContributorType(), 'contributor_type');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contributor-types/{id}/delete", name="parameters_contributor_types_delete")
     */
    public function contributorTypeDeleteAction(Request $request, ContributorType $contributor_type)
    {
        return $this->typeRemove($request, $contributor_type, 'contributor_type');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/payment-types", name="parameters_payment_types")
     */
    public function paymentTypesAction()
    {
        return $this->render('parameter/payment_type/index.html.twig', [
            'payment_types' => $this->get('repository.payment_type')->findBy([], [
                'name' => 'ASC',
            ]),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/payment-types/{id}/edit", name="parameters_payment_types_edit")
     */
    public function paymentTypeEditAction(Request $request, PaymentType $payment_type)
    {
        return $this->typeEdit($request, $payment_type, 'payment_type');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/payment-types/add", name="parameters_payment_types_add")
     */
    public function paymentTypeAddAction(Request $request)
    {
        return $this->typeEdit($request, new PaymentType(), 'payment_type');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/payment-types/{id}/delete", name="parameters_payment_types_delete")
     */
    public function paymentTypeDeleteAction(Request $request, PaymentType $payment_type)
    {
        return $this->typeRemove($request, $payment_type, 'payment_type');
    }

    /**
     * @param Request $request
     * @param         $object
     * @param         $type
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function typeEdit(Request $request, $object, $type)
    {
        $form = $this->createForm($type, $object);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $entity_manger = $this->getDoctrine()->getManager();
            $entity_manger->persist($object);
            $entity_manger->flush();
            $this->get('session.flash_bag')->add('success', 'item.saved');
            return $this->redirectToRoute('parameters_'.$type.'s');
        }

        return $this->render('parameter/'.$type.'/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param         $object
     * @param         $type
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function typeRemove(Request $request, $object, $type)
    {
        $form = $this->createForm($type.'_delete', $object);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->remove($object);
            $entity_manager->flush();
            $this->get('session.flash_bag')->add('success', 'item.removed');
            return $this->redirectToRoute('parameters_'.$type.'s');
        }

        return $this->render('parameter/'.$type.'/delete.html.twig', [
            'form' => $form->createView(),
            $type => $object,
        ]);
    }
}