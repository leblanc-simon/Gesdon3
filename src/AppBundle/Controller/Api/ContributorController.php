<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Address;
use AppBundle\Entity\Contributor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContributorController
 * @package AppBundle\Controller\Api
 *
 * @Route("/api/contributor")
 */
class ContributorController extends Controller
{
    /**
     * @Route("/{email}", name="api_contributor_by_email")
     */
    public function getByMailAction(Contributor $contributor)
    {
        return new JsonResponse([
            'id' => $contributor->getId(),
            'email' => $contributor->getEmail(),
            'firstname' => $contributor->getFirstname(),
            'lastname' => $contributor->getLastname(),
            'contributor_type' => $contributor->getContributorType()->getId(),
        ]);
    }

    /**
     * @Route("/{email}/last-address", name="api_contributor_last_address_by_email")
     */
    public function getLastAddressByMailAction(Contributor $contributor)
    {
        /** @var Address $address */
        $address = $contributor->getAddresses()->last();

        if (null === $address) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse([
            'id' => $address->getId(),
            'street' => $address->getStreet(),
            'additional' => $address->getAdditional(),
            'zip_code' => $address->getZipCode(),
            'city' => $address->getCity(),
            'country' => $address->getCountry(),
        ]);
    }
}
