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
 * Class NurlController
 *
 * @Route("nurl")
 * @Security("has_role('ROLE_USER')")
 */
class NurlController extends Controller
{
    /**
     * @Route("/nurls/list")
     */
    public function listAction(Request $request)
    {
        $nurlRepository = $this->getDoctrine()->getRepository('AppBundle:Nurl');
        $nurls = $nurlRepository->findAll();

        $argsArray = [
            'nurls' => $nurls
        ];

        $templateName = 'nurls/list';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/nurls/new/{title}")
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
     * @Route("/nurls/delete/{id}")
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
     * @Route("/nurls/update/{id}/{newTitle}")
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
