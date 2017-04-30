<?php

namespace SMS\ShipmentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Implementations given here are dummy ones.
 *
 * Class PickupRateController
 */
class PickupRateController extends Controller
{
    /**
     * Processes the shipping.
     *
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function processAction(Request $request)
    {
        //Todo: the real shipment processor API that gets some transaction id back
        $transaction = md5(time() . uniqid());
        return new JsonResponse([
            'success' => $transaction
        ]);
    }
}
