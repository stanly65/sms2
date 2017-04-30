<?php

namespace SMS\CatalogBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SMS\CatalogBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/list", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('SMSCatalogBundle:Category')->findAll();

        return $this->render('SMSCatalogBundle:Default:category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Creates a new category entity.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $defaultImageName = 'noimage.gif';
        $category = new Category();
        $form = $this->createForm('SMS\CatalogBundle\Form\CategoryType', $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $category->getImage()) {
                $name = $this->get('sms_catalog.image_uploader')->upload($image);
                $category->setImage($name);
            } else {
                $category->setImage($defaultImageName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('SMSCatalogBundle:Default:category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a category entity.
     *
     * @param Category $category
     *
     * @return Response
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('SMSCatalogBundle:Default:category/show.html.twig', [
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @param Request $request
     * @param Category $category
     *
     * @return RedirectResponse|Response
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        $existingImage = $category->getImage();
        if ($existingImage) {
            $category->setImage(
                new File($this->getParameter('sms_catalog_images_directory') . '/' . $existingImage)
            );
        }
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('SMS\CatalogBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($image = $category->getImage()) {
                $name = $this->get('sms_catalog.image_uploader')->upload($image);
                $category->setImage($name);
            } else {
                $category->setImage($existingImage);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_edit', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('SMSCatalogBundle:Default:category/edit.html.twig', [
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a category entity.
     *
     * @param Request $request
     * @param Category $category
     *
     * @return RedirectResponse
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $existingImage = $category->getImage();
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
            if ($existingImage != 'noimage.gif') {
                $filePath = $this->getParameter('sms_catalog_images_directory') . '/' . $existingImage;
                unlink($filePath);
            }
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category
     *
     * @return Form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', [
                'id' => $category->getId()
            ]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
