<?php

namespace SMS\SalesBundle\Controller;

use AppBundle\Entity\User;
use DateTime;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use SMS\SalesBundle\Entity\CartItem;
use SMS\SalesBundle\Entity\SalesOrder;
use SMS\SalesBundle\Entity\SalesOrderItem;

class CheckoutController extends Controller
{
    /**
     * Constructs first checkout step gathering the shipment information.
     *
     * @return Response
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $form = $this->getAddressForm($user);
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('SMSSalesBundle:Cart')->findOneBy(['user' => $user]);
        $items = $cart->getItems();
        $total = CartController::calculateTotalPrice($items);

        return $this->render('SMSSalesBundle:Default:checkout/index.html.twig', [
            'user' => $user,
            'items' => $items,
            'cart_subtotal' => $total,
            'shipping_address_form' => $form->createView(),
            'shipping_methods' => $this->get('sms_sales.shipment')->getShipmentMethods()
        ]);
    }

    /**
     * Constructs second checkout step gathering the payment information.
     *
     * This method stores relevant information into session.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function paymentAction(Request $request)
    {
        $user = $this->getUser();
        $addressForm = $this->getAddressForm($user);
        $addressForm->handleRequest($request);
        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('SMSSalesBundle:Cart')->findOneBy(['user' => $user]);
            $items = $cart->getItems();
            $cartSubtotal = CartController::calculateTotalPrice($items);
            $shipmentMethod = $request->request->get('shipment_method');
            $shipmentMethod = explode('____', $shipmentMethod);
            $shipmentMethodCode = $shipmentMethod[0];
            $shipmentMethodDeliveryCode = $shipmentMethod[1];
            $shipmentMethodDeliveryPrice = $shipmentMethod[2];
            $checkoutInfo = $addressForm->getData();
            $checkoutInfo['shipment_method'] = $shipmentMethodCode . '____' . $shipmentMethodDeliveryCode;
            $checkoutInfo['shipment_price'] = $shipmentMethodDeliveryPrice;
            $checkoutInfo['items_price'] = $cartSubtotal;
            $checkoutInfo['total_price'] = $cartSubtotal + $shipmentMethodDeliveryPrice;
            $this->get('session')->set('checkoutInfo', $checkoutInfo);

            return $this->render('SMSSalesBundle:Default:checkout/payment.html.twig', [
                'user' => $user,
                'items' => $items,
                'cart_subtotal' => $cartSubtotal,
                'delivery_subtotal' => $shipmentMethodDeliveryPrice,
                'order_total' => $cartSubtotal + $shipmentMethodDeliveryPrice,
                'payment_methods' => $this->get('sms_sales.payment')->getPaymentMethods()
            ]);
        }

        return $this->redirectToRoute('sms_sales_checkout');
    }

    /**
     * Creates an order.
     *
     * Once the POST submission hits the controller, a new order with all of the related
     * items gets created. At the same time, the cart and cart items are cleared. Finally, the
     * customer is redirected to the order success page.
     *
     * @return RedirectResponse
     */
    public function processAction()
    {
        $salesOrder = new SalesOrder;
        $now = new DateTime;
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $checkoutInfo = $this->get('session')->get('checkoutInfo');
        $salesOrder->setUser($user);
        $salesOrder->setItemsPrice($checkoutInfo['items_price']);
        $salesOrder->setShipmentPrice($checkoutInfo['shipment_price']);
        $salesOrder->setTotalPrice($checkoutInfo['total_price']);
        $salesOrder->setPaymentMethod($_POST['payment_method']);
        $salesOrder->setShipmentMethod($checkoutInfo['shipment_method']);
        $salesOrder->setCreatedAt($now);
        $salesOrder->setModifiedAt($now);
        $salesOrder->setUserEmail($user->getEmail());
        $salesOrder->setUserFirstName($checkoutInfo['address_first_name']);
        $salesOrder->setUserLastName($checkoutInfo['address_last_name']);
        $salesOrder->setAddressCountry($checkoutInfo['address_country']);
        $salesOrder->setAddressCity($checkoutInfo['address_city']);
        $salesOrder->setAddressPostcode($checkoutInfo['address_postcode']);
        $salesOrder->setAddressStreet($checkoutInfo['address_street']);
        $salesOrder->setAddressTelephone($checkoutInfo['address_telephone']);
        $salesOrder->setStatus(SalesOrder::STATUS_PROCESSING);
        $em->persist($salesOrder);
        $em->flush();
        $cart = $em->getRepository('SMSSalesBundle:Cart')->findOneBy(['user' => $user]);
        $items = $cart->getItems();
        foreach ($items as $item) {
            /** @var CartItem $item */
            $orderItem = new SalesOrderItem;
            $orderItem->setSalesOrder($salesOrder);
            $orderItem->setTitle($item->getProduct()->getTitle());
            $orderItem->setQty($item->getQty());
            $orderItem->setUnitPrice($item->getUnitPrice());
            $orderItem->setTotalPrice($item->getQty() * $item->getUnitPrice());
            $orderItem->setModifiedAt($now);
            $orderItem->setCreatedAt($now);
            $orderItem->setProduct($item->getProduct());
            $item->getProduct()->setQty($item->getProduct()->getQty() - $item->getQty());
            $em->persist($orderItem);
            $em->remove($item);
        }
        $em->remove($cart);
        $em->flush();
        $this->get('session')->set('last_order', $salesOrder->getId());

        return $this->redirectToRoute('sms_sales_checkout_success');
    }

    /**
     * Creates the order success page.
     *
     * @return Response
     */
    public function successAction()
    {
        return $this->render('SMSSalesBundle:Default:checkout/success.html.twig', [
            'last_order' => $this->get('session')->get('last_order')
        ]);
    }

    /**
     * Creates address form.
     *
     * @param User $user
     *
     * @return Form|FormInterface
     */
    private function getAddressForm(User $user)
    {
        return $this->createFormBuilder()
            ->add('address_first_name', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
                'data' => $user->getFirstName()
            ])
            ->add('address_last_name', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
                'data' => $user->getLastName()
            ])
            ->add('address_telephone', TextType::class, [
                'constraints' => new Length(['min' => 7]),
                'attr' => ['class' => 'form-control'],
                'data' => $user->getPhoneNumber()
            ])
            ->add('address_country', CountryType::class, [
                'attr' => ['class' => 'form-control'],
                'data' => $user->getCountry()
            ])
            ->add('address_city', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
                'data' => $user->getCity()
            ])
            ->add('address_postcode', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
                'data' => $user->getPostcode()
            ])
            ->add('address_street', TextType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
                'data' => $user->getStreet()
            ])
            ->getForm()
        ;
    }
}
