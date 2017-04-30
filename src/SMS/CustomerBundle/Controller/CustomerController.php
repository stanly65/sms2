<?php

namespace SMS\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Customer controller.
 *
 * @Route("customer")
 */
class CustomerController extends Controller
{
    /**
     * Displays "Account" page.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/account", name="customer_account")
     * @Method({"GET", "POST"})
     */
    public function accountAction(Request $request)
    {
        $customer = $this->getUser();
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $editForm = $this->createForm(
            'SMS\CustomerBundle\Form\CustomerType',
            $customer,
            ['action' => $this->generateUrl('customer_account')]
        );
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            $this->addFlash('success', 'Account updated.');

            return $this->redirectToRoute('customer_account');
        }

        return $this->render('SMSCustomerBundle:Default:customer/account.html.twig', [
            'customer' => $customer,
            'form' => $editForm->createView(),
            'customer_orders' => $this->get('sms_sales.customer_orders')->getOrders()
        ]);
    }
}
