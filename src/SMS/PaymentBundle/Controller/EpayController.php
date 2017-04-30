<?php

namespace SMS\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Implementations given here are dummy ones.
 *
 * Class EpayController
 * @package SMS\PaymentBundle\Controller
 */
class EpayController extends Controller
{
    /**
     * Authorizes the transaction.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function authorizeAction(Request $request)
    {
        //Todo: the real payment processor API that gets some transaction id back
        $transaction = md5(time() . uniqid());
        if ($transaction) {
            return new JsonResponse([
                'success' => $transaction
            ]);
        }
        return new JsonResponse([
            'error' => 'Error occurred while processing Epay payment.'
        ]);
    }

    /**
     * Captures the funds after the authorization.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function captureAction(Request $request)
    {
        //Todo: the real payment processor API that gets some transaction id back
        $transaction = md5(time() . uniqid());
        if ($transaction) {
            return new JsonResponse([
                'success' => $transaction
            ]);
        }
        return new JsonResponse([
            'error' => 'Error occurred while processing Epay payment.'
        ]);
    }

    /**
     * Performs the cancelation based on a previously stored authorization token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cancelAction(Request $request)
    {
        //Todo: the real payment processor API that gets some transaction id back
        $transaction = md5(time() . uniqid());
        if ($transaction) {
            return new JsonResponse([
                'success' => $transaction
            ]);
        }
        return new JsonResponse([
            'error' => 'Error occurred while processing Epay payment.'
        ]);
    }
}
