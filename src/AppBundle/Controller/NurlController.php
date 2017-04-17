<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    public function newAction(Nurl $nurl)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($nurl);

        $em->flush();

        return $this->redirectToRoute('nurl_list');
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

    /**
     * @Route("/nurls/new", name="nurls_new_form")
     */
    public function newFormAction(Request $request)
    {
        $nurl = new Nurl();

        $form = $this->createFormBuilder($nurl)
            ->add('title', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create NURL'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nurl = $form->getData();
            return $this->newAction($nurl);
        }

        $argsArray = [
            'form' => $form->createView(),
        ];

        $templateName = 'nurls/new';
        return $this->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @Route("/nurls/processNewForm", name="nurls_process_new_form")
     */
    public function processNewFormAction(Request $request)
    {
        $title = $request->request->get('title');

        if(empty($title)) {
            $this->addFlash(
                'error',
                'nurl name cannot be an empty string'
            );

            return $this->newFormAction($request);
        }

        return $this->newAction($title);
    }
}
