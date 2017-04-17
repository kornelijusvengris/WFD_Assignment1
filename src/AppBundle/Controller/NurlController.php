<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Entity\Nurl;

/**
 * Nurl controller.
 *
 * @Route("nurl")
 * @Security("has_role('ROLE_ADMIN')")
 */
class NurlController extends Controller
{
    /**
     * Lists all recipe entities.
     *
     * @Route("/list", name="nurl_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        return $this->render('NURLs/list.html.twig', array('nurls' => $nurls,));
    }

    /**
     * Creates a new recipe entity.
     *
     * @Route("/new", name="new_nurl")
     * @Method({"GET", "POST"})
     */
    public function newAction($title)
    {
        $nurl = new Nurl();
        $nurl->setTitle($title);

        $em = $this->getDoctrine()->getManager();

        $em->persist($nurl);

        $em->flush();

        return new Response('Created new NURL with id ' . $nurl->getId());
    }

    /**
     *
     * @Route("/delete/{id}", name="delete_nurl")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $nurlRepository = $this->getDoctrine()->getRepository('AppBundle:Nurl');

        $nurl = $nurlRepository->find($id);

        $em->remove($nurl);

        $em->flush();

        return new Response('Deleted NURL with id ' . $id);
    }

    /**
     *
     * @Route("/update/{id}", name="edit_nurl")
     * @Method({"GET", "POST"})
     */
    public function updateAction($id, $newTitle)
    {
        $em = $this->getDoctrine()->getManager();

        $nurl = $em->getRepository('AppBundle:Nurl')->find($id);

        if (!$nurl)
        {
            throw $this->createNotFoundException('No NURL found for id ' . $id);
        }

        $nurl->setTitle($newTitle);

        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
