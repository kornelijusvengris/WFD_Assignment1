<?php

namespace AppBundle\Controller;

use AppBundle\Entity\NurlCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Nurlcollection controller.
 *
 * @Route("nurlcollection")
 */
class NurlCollectionController extends Controller
{
    /**
     * Lists all nurlCollection entities.
     *
     * @Route("/", name="nurlcollection_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nurlCollections = $em->getRepository('AppBundle:NurlCollection')->findAll();

        return $this->render('nurlcollection/index.html.twig', array(
            'nurlCollections' => $nurlCollections,
        ));
    }

    /**
     * Creates a new nurlCollection entity.
     *
     * @Route("/new", name="nurlcollection_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $nurlCollection = new Nurlcollection();
        $form = $this->createForm('AppBundle\Form\NurlCollectionType', $nurlCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nurlCollection);
            $em->flush();

            return $this->redirectToRoute('nurlcollection_show', array('id' => $nurlCollection->getId()));
        }

        return $this->render('nurlcollection/new.html.twig', array(
            'nurlCollection' => $nurlCollection,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a nurlCollection entity.
     *
     * @Route("/{id}", name="nurlcollection_show")
     * @Method("GET")
     */
    public function showAction(NurlCollection $nurlCollection)
    {
        $deleteForm = $this->createDeleteForm($nurlCollection);

        return $this->render('nurlcollection/show.html.twig', array(
            'nurlCollection' => $nurlCollection,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nurlCollection entity.
     *
     * @Route("/{id}/edit", name="nurlcollection_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, NurlCollection $nurlCollection)
    {
        $deleteForm = $this->createDeleteForm($nurlCollection);
        $editForm = $this->createForm('AppBundle\Form\NurlCollectionType', $nurlCollection);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nurlcollection_edit', array('id' => $nurlCollection->getId()));
        }

        return $this->render('nurlcollection/edit.html.twig', array(
            'nurlCollection' => $nurlCollection,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a nurlCollection entity.
     *
     * @Route("/{id}", name="nurlcollection_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, NurlCollection $nurlCollection)
    {
        $form = $this->createDeleteForm($nurlCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nurlCollection);
            $em->flush();
        }

        return $this->redirectToRoute('nurlcollection_index');
    }

    /**
     * Creates a form to delete a nurlCollection entity.
     *
     * @param NurlCollection $nurlCollection The nurlCollection entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NurlCollection $nurlCollection)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurlcollection_delete', array('id' => $nurlCollection->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
