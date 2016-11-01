<?php

namespace Crmp\CrmBundle\Controller;

use AppBundle\Controller\AbstractCrmpController;
use Crmp\CrmBundle\Entity\Setting;
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

            $form->handleRequest($request);
            $isSubmitted = $isSubmitted || $form->isSubmitted();

            $isValid = $isValid && $form->isValid();

            if (! $form->isSubmitted() || ! $form->isValid()) {
                // nothing submitted here or invalid => do not persist this data
                continue;
            }

            // persist data
            $data = array_merge($data, (array) $form->getData());
        }

        if ($isSubmitted && $isValid) {
            $settingsRepository = $this->get('crmp.setting.repository');
            foreach ($data as $name => $value) {
                $setting = new Setting();
                $setting->setName($name);
                $setting->setValue($value);
                $setting->setUser($this->getUser());

                $settingsRepository->add($setting);
            }

            $settingsRepository->flush();

            // form has been send => redirect to prevent additional save on reload
            return $this->redirectToRoute('crmp_crm_settings');
        }


        return $this->render('CrmpCrmBundle:Settings:index.html.twig');
    }
}
