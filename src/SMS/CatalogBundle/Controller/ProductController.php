<?php

namespace SMS\CatalogBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use SMS\CatalogBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/list", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('SMSCatalogBundle:Product')->findAll();

        return $this->render('SMSCatalogBundle:Default:product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Creates a new product entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $defaultImageName = 'noimage.gif';
        $product = new Product();
        $form = $this->createForm('SMS\CatalogBundle\Form\ProductType', $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $product->getImage()) {
                $name = $this->get('sms_catalog.image_uploader')->upload($image);
                $product->setImage($name);
            } else {
                $product->setImage($defaultImageName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('SMSCatalogBundle:Default:product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a product entity.
     *
     * @param Product $product
     *
     * @return Response
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('SMSCatalogBundle:Default:product/show.html.twig', [
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @param Request $request
     * @param Product $product
     *
     * @return RedirectResponse|Response
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $existingImage = $product->getImage();
        if ($existingImage) {
            $product->setImage(
                new File($this->getParameter('sms_catalog_images_directory') . '/' . $existingImage)
            );
        }
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('SMS\CatalogBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($image = $product->getImage()) {
                $name = $this->get('sms_catalog.image_uploader')->upload($image);
                $product->setImage($name);
            } else {
                $product->setImage($existingImage);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('SMSCatalogBundle:Default:product/edit.html.twig', [
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a product entity.
     *
     * @param Request $request
     * @param Product $product
     *
     * @return RedirectResponse
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $existingImage = $product->getImage();
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            if ($existingImage != 'noimage.gif') {
                $filePath = $this->getParameter('sms_catalog_images_directory') . '/' . $existingImage;
                unlink($filePath);
            }
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product
     *
     * @return Form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', [
                'id' => $product->getId()
            ]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
