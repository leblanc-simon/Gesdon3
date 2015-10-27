<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Donation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DonationController
 * @package AppBundle\Controller
 * @Route("/donations")
 */
class DonationController extends Controller
{
    /**
     * @Route("/{page}", name="donations", defaults={"page" = 1}, requirements={"page" = "\d+"})
     */
    public function indexAction($page)
    {
        $donations = $this
            ->get('paginator')
            ->setCurrentPage($page)
            ->setQuery($this->get('repository.donation')->getQueryForAll())
        ;

        return $this->render('donations/index.html.twig', [
            'donations' => $donations
        ]);
    }

    /**
     * @Route("/add", name="donations_add")
     */
    public function addAction(Request $request)
    {
        return $this->formDonation($request, 'add');
    }

    /**
     * @Route("/edit/{id}", name="donations_edit")
     */
    public function editAction(Donation $donation, Request $request)
    {
        return $this->formDonation($request, 'edit', $donation);
    }

    /**
     * @param Request       $request
     * @param string        $type
     * @param Donation|null $donation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function formDonation(Request $request, $type, Donation $donation = null)
    {
        $donation_manager = $this->get('manager.donation');

        if (null === $donation) {
            $donation = $donation_manager->newEntity();
        }

        $form = $this->createForm('donation', $donation);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $donation_manager
                ->setDonation($donation)
                ->checkIfContributorExist($type)
                ->save($donation);
            return $this->redirectToRoute('donations');
        }

        return $this->render(sprintf('donations/%s.html.twig', $type), [
            'form' => $form->createView(),
            'donation' => $donation,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="donations_delete")
     */
    public function deleteAction(Donation $donation, Request $request)
    {
        $form = $this->createForm('donation_delete', $donation);
        $form->handleRequest($request);

        if ($form->isValid() === true) {
            $this->get('manager.donation')
                ->setDonation($donation)
                ->remove();
            return $this->redirectToRoute('donations');
        }

        return $this->render('donations/delete.html.twig', [
            'form' => $form->createView(),
            'donation' => $donation,
        ]);
    }
}
