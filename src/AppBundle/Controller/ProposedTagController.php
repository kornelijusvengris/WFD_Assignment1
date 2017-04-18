<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProposedTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Proposedtag controller.
 *
 * @Route("proposedtag")
 */
class ProposedTagController extends Controller
{
    /**
     * Lists all proposedTag entities.
     *
     * @Route("/", name="proposedtag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proposedTags = $em->getRepository('AppBundle:ProposedTag')->findAll();

        return $this->render('proposedtag/index.html.twig', array(
            'proposedTags' => $proposedTags,
        ));
    }

    /**
     * Creates a new proposedTag entity.
     *
     * @Route("/new", name="proposedtag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $proposedTag = new Proposedtag();
        $form = $this->createForm('AppBundle\Form\ProposedTagType', $proposedTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proposedTag);
            $em->flush();

            return $this->redirectToRoute('proposedtag_show', array('id' => $proposedTag->getId()));
        }

        return $this->render('proposedtag/new.html.twig', array(
            'proposedTag' => $proposedTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a proposedTag entity.
     *
     * @Route("/{id}", name="proposedtag_show")
     * @Method("GET")
     */
    public function showAction(ProposedTag $proposedTag)
    {
        $deleteForm = $this->createDeleteForm($proposedTag);

        return $this->render('proposedtag/show.html.twig', array(
            'proposedTag' => $proposedTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing proposedTag entity.
     *
     * @Route("/{id}/edit", name="proposedtag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProposedTag $proposedTag)
    {
        $deleteForm = $this->createDeleteForm($proposedTag);
        $editForm = $this->createForm('AppBundle\Form\ProposedTagType', $proposedTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proposedtag_edit', array('id' => $proposedTag->getId()));
        }

        return $this->render('proposedtag/edit.html.twig', array(
            'proposedTag' => $proposedTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a proposedTag entity.
     *
     * @Route("/{id}", name="proposedtag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProposedTag $proposedTag)
    {
        $form = $this->createDeleteForm($proposedTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proposedTag);
            $em->flush();
        }

        return $this->redirectToRoute('proposedtag_index');
    }

    /**
     * Creates a form to delete a proposedTag entity.
     *
     * @param ProposedTag $proposedTag The proposedTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProposedTag $proposedTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proposedtag_delete', array('id' => $proposedTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
