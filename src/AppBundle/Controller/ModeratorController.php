<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Moderator controller.
 *
 * @Route("moderator")
 * @Security("has_role('ROLE_MOD')")
 */
class ModeratorController extends Controller
{
    /**
     * @Route("/", name="moderator_index")
     */
    public function adminAction()
    {
        $templateName = '/moderator/index';
        return $this->render($templateName.'.html.twig');
    }
}