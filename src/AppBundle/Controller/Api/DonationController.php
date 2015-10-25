<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContributorController
 * @package AppBundle\Controller\Api
 *
 * @Route("/api/donation")
 */
class DonationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("", name="api_donation_post", methods={"post"})
     *
     * @api {post} /api/donation Add a donation
     * @apiName PostDonation
     * @apiGroup Donation
     * @apiVersion 1.0.0
     *
     * @apiParam {string} [firstname] [Contributor] firstname
     * @apiParam {string} [lastname] [Contributor] lastname
     * @apiParam {string} [company] [Contributor] company
     * @apiParam {string} email [Contributor] email
     * @apiParam {string} [contributor_type=personal] [Contributor] type of contributor (slug: personal, company, association, ...)
     * @apiParam {string} street [Address] street
     * @apiParam {string} [additional] [Address] additional
     * @apiParam {string} zip_code [Address] zip code
     * @apiParam {string} city [Address] city
     * @apiParam {string} country [Address] country (ISO Code)
     * @apiParam {number} amount [Donation] amount of donation
     * @apiParam {number} [fee] [Donation] fee stolen by bank
     * @apiParam {string} via [Donation] origin of donation
     * @apiParam {string} payment_type [Donation] payment type (slug : cb, check, cash, bankwire, paypal, flattr, other, ...)
     * @apiParam {string} [reference] [Donation] reference of transaction
     *
     * @apiSuccess (201) null Donation created
     * @apiError (400) error
     */
    public function postAction(Request $request)
    {
        try {
            $this
                ->get('manager.api_donation')
                ->extractFromRequest($request)
                ->save();
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse(null, 201);
    }
}