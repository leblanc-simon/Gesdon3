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
     * @Route(
     *      "/{email}",
     *      name="api_contributor_by_email",
     *      methods={"get"}
     * )
     *
     * @api {get} /api/contributor/:email Request contributor information
     * @apiName GetContributor
     * @apiGroup Contributor
     * @apiVersion 1.0.0
     *
     * @apiParam {String} email The email's contributor
     *
     * @apiSuccess (200) {Integer} id Id of contributor
     * @apiSuccess (200) {String} email Email of contributor
     * @apiSuccess (200) {String} firstname Firstname of contributor
     * @apiSuccess (200) {String} lastname Lastname of contributor
     * @apiSuccess (200) {Integer} contributor_type Id of the contributor type
     * @apiError (404) null Contributor not found
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
     * @Route(
     *      "/{email}/last-address",
     *      name="api_contributor_last_address_by_email",
     *      methods={"get"}
     * )
     *
     * @api {get} /api/contributor/:email/last-address Request the last address of contributor
     * @apiName GetContributorLastAddress
     * @apiGroup Contributor
     * @apiVersion 1.0.0
     *
     * @apiParam {String} email The email's contributor
     *
     * @apiSuccess (200) {Integer} id Id of address
     * @apiSuccess (200) {String} street Street of the contributor
     * @apiSuccess (200) {String} additional Addtional street of the contributor
     * @apiSuccess (200) {String} zip_code Zip Code of the contributor
     * @apiSuccess (200) {String} city City of the contributor
     * @apiSuccess (200) {String} country ISO code of the country
     * @apiError (404) null Address or Contributor not found
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
