<?php

namespace SMS\SalesBundle\Controller;

use AppBundle\Entity\User;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SMS\CatalogBundle\Entity\Product;
use SMS\SalesBundle\Entity\Cart;
use SMS\SalesBundle\Entity\CartItem;
use Doctrine\ORM\EntityManager;

class CartController extends Controller
{
    /**
     * Displays "Shopping Cart" page.
     *
     * @return RedirectResponse|Response
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('SMSSalesBundle:Cart')->findOneBy(['user' => $user]);
        $items = $cart->getItems();
        $total = self::calculateTotalPrice($items);

        return $this->render('SMSSalesBundle:Default:cart/index.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * Updates shopping cart.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function updateAction(Request $request)
    {
        $items = $request->get('item');
        $em = $this->getDoctrine()->getManager();
        foreach ($items as $id => $qty) {
            $cartItem = $em->getRepository('SMSSalesBundle:CartItem')->find($id);
            if (intval($qty) > 0) {
                $cartItem->setQty($qty);
                $em->persist($cartItem);
            } else {
                $em->remove($cartItem);
            }
        }
        $em->flush();
        $this->addFlash('success', 'Cart updated.');

        return $this->redirectToRoute('sms_sales_cart');
    }

    /**
     * Adds products to shopping cart.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function addAction($id)
    {
        if ($user = $this->getUser()) {
            /**
             * @var $product Product
             * @var $user User
             * @var $em EntityManager
             */
            $now = new DateTime;
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('SMSCatalogBundle:Product')->find($id);
            $cart = $em->getRepository('SMSSalesBundle:Cart')->findOneBy(['user' => $user]);
            $cart = $this->persistCart($user, $now, $em, $cart);
            $em->flush();
            $cartItem = $em->getRepository('SMSSalesBundle:CartItem')->findOneBy(['cart' => $cart, 'product' => $product]);
            $this->persistCartItem($now, $cart, $product, $em, $cartItem);
            $em->flush();
            $this->addFlash('success', sprintf('%s successfully added to cart', $product->getTitle()));

            return $this->redirectToRoute('sms_sales_cart');
        } else {
            $this->addFlash('warning', 'Only logged in users can add to cart.');

            return $this->redirectToRoute('login');
        }
    }

    /**
     * Calculates total price.
     *
     * @param CartItem[] $items
     *
     * @return float
     */
    public static function calculateTotalPrice($items)
    {
        $total = null;
        foreach ($items as $item) {
            $total += floatval($item->getQty() * $item->getUnitPrice());
        }

        return $total;
    }

    /**
     * Creates the cart for current user.
     *
     * @param User $user
     * @param DateTime $now
     * @param EntityManager $em
     * @param Cart $cart
     *
     * @return Cart
     */
    private function persistCart(User $user, DateTime $now, EntityManager $em, Cart $cart = null)
    {
        if (!$cart) {
            $cart = new Cart;
            $cart->setUser($user);
            $cart->setCreatedAt($now);
            $cart->setModifiedAt($now);
        } else {
            $cart->setModifiedAt($now);
        }
        $em->persist($cart);

        return $cart;
    }

    /**
     * Creates the chosen cart item.
     *
     * @param DateTime $now
     * @param Cart $cart
     * @param Product $product
     * @param EntityManager $em
     * @param CartItem $cartItem
     */
    private function persistCartItem(DateTime $now, Cart $cart, Product $product, EntityManager $em, CartItem $cartItem = null)
    {
        if (!$cartItem) {
            $cartItem = new CartItem;
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQty(1);
            $cartItem->setUnitPrice($product->getPrice());
            $cartItem->setCreatedAt($now);
            $cartItem->setModifiedAt($now);
        } else {
            $cartItem->setQty($cartItem->getQty() + 1);
            $cartItem->setModifiedAt($now);
        }
        $em->persist($cartItem);
    }
}
