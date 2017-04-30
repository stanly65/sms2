<?php

namespace SMS\SalesBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use SMS\SalesBundle\Entity\SalesOrder;

/**
 * SalesOrder controller.
 *
 * @Route("/order")
 */
class SalesOrderController extends Controller
{
    /**
     * Lists all SalesOrder entities.
     * 
     * @return Response
     *
     * @Route("/", name="salesorder_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $salesOrders = $em->getRepository('SMSSalesBundle:SalesOrder')->findAll();

        return $this->render('SMSSalesBundle:Default:salesorder/index.html.twig', [
            'salesOrders' => $salesOrders,
        ]);
    }

    /**
     * Finds and displays a SalesOrder entity.
     *
     * @param SalesOrder $salesOrder
     *
     * @return Response
     *
     * @Route("/{id}", name="salesorder_show")
     * @Method("GET")
     */
    public function showAction(SalesOrder $salesOrder)
    {
        return $this->render('SMSSalesBundle:Default:salesorder/show.html.twig', [
            'salesOrder' => $salesOrder,
        ]);
    }

    /**
     * Displays a form to edit an existing SalesOrder entity.
     *
     * @param Request $request
     * @param SalesOrder $salesOrder
     *
     * @return RedirectResponse|Response
     *
     * @Route("/{id}/edit", name="salesorder_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SalesOrder $salesOrder)
    {
        $editForm = $this->createForm('SMS\SalesBundle\Form\SalesOrderType', $salesOrder);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salesOrder);
            $em->flush();
            $this->addFlash('success', 'Order updated.');

            return $this->redirectToRoute('salesorder_edit', ['id' => $salesOrder->getId()]);
        }

        return $this->render('SMSSalesBundle:Default:salesorder/edit.html.twig', [
            'salesOrder' => $salesOrder,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Changes the order status to "canceled".
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function cancelAction($id)
    {
        if ($user = $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $salesOrder = $em->getRepository('SMSSalesBundle:SalesOrder')
                ->findOneBy(['user' => $user, 'id' => $id]);
            if ($salesOrder->getStatus() === SalesOrder::STATUS_PROCESSING) {
                $salesOrder->setStatus(SalesOrder::STATUS_CANCELED);
                $em->persist($salesOrder);
                $em->flush();
                $this->addFlash('success', 'Order updated.');

                return $this->redirectToRoute('customer_account');
            }
        }

        $this->addFlash('warning', 'Order can not be updated.');
        return $this->redirectToRoute('customer_account');
    }
}
