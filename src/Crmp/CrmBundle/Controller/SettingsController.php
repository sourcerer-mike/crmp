<?php

namespace Crmp\CrmBundle\Controller;

use AppBundle\Controller\AbstractCrmpController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SettingsController
 *
 * @Route("/settings")
 *
 * @package Crmp\CrmBundle\Controller
 */
class SettingsController extends AbstractCrmpController
{
    /**
     * @Route("/", name="crmp_crm_settings")
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'CrmpCrmBundle:Settings:index.html.twig'
        );
    }
}