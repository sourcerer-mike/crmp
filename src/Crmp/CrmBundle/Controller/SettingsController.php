<?php

namespace Crmp\CrmBundle\Controller;

use AppBundle\Controller\AbstractCrmpController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * Show common settings.
     *
     * @Route("/", name="crmp_crm_settings")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'CrmpCrmBundle:Settings:index.html.twig'
        );
    }
}
