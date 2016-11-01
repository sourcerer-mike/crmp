<?php

namespace Crmp\CrmBundle\Controller;

use AppBundle\Controller\AbstractCrmpController;
use Crmp\CrmBundle\Twig\AbstractSettingsPanel;
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
        // Flag the current state
        $isValid     = true;
        $isSubmitted = false;

        // Data that shall be written
        $data = [];

        // forward request to form
        foreach ($this->get('crmp_crm.settings.panels') as $panel) {
            /** @var AbstractSettingsPanel $panel */

            $form        = $panel->getForm();
            $isSubmitted = $isSubmitted || $form->isSubmitted();

            if ($form->isSubmitted()) {
                // something already happened => skip this form
                continue;
            }

            $form->handleRequest($request);

            $isValid = $isValid && $form->isValid();

            if (! $form->isSubmitted() || ! $form->isValid()) {
                // nothing submitted here or invalid => do not persist this data
                continue;
            }

            // persist data
            $data = array_merge($data, $form->getData());
        }

        if ($isSubmitted && $isValid) {
            // form has been send => redirect to prevent additional save on reload
            return $this->redirectToRoute('crmp_crm_settings');
        }


        return $this->render('CrmpCrmBundle:Settings:index.html.twig');
    }
}
