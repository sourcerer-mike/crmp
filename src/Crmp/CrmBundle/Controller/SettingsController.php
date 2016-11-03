<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CoreDomain\Settings\SettingRepositoryInterface;
use Crmp\CrmBundle\Entity\Setting;
use Crmp\CrmBundle\Twig\AbstractSettingsPanel;
use Doctrine\Common\Collections\Collection;
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

        // Data that shall be written / already exists
        $data               = [];
        $settingsRepository = $this->get('crmp.setting.repository');
        $currentSettings    = $this->getCurrentSettings($settingsRepository);

        // forward request to form
        foreach ($this->get('crmp_crm.settings.panels') as $panel) {
            /** @var AbstractSettingsPanel $panel */

            $form = $panel->getForm();

            $form->setData($currentSettings);
            $form->handleRequest($request);

            $isSubmitted = $isSubmitted || $form->isSubmitted();
            $isValid     = $isValid && $form->isValid();

            if (! $form->isSubmitted() || ! $form->isValid()) {
                // nothing submitted here or invalid => do not persist this data
                continue;
            }

            // persist data
            $data = array_merge($data, (array) $form->getData());
        }

        if ($isSubmitted && $isValid) {
            foreach ($data as $name => $value) {
                $setting = new Setting();
                $setting->setName($name);
                $setting->setValue($value);
                $setting->setUser($this->getUser());

                $settingsRepository->persist($setting);
            }

            $settingsRepository->flush();

            // form has been send => redirect to prevent additional save on reload
            return $this->redirectToRoute('crmp_crm_settings_index');
        }


        return $this->render('CrmpCrmBundle:Settings:index.html.twig');
    }

    /**
     * Turn collection of settings into associative array.
     *
     * @param Collection $collection
     *
     * @return array
     */
    protected function flattenSettings($collection)
    {
        $currentSettings = [];
        foreach ($collection->toArray() as $setting) {
            /** @var Setting $setting */
            $currentSettings[$setting->getName()] = $setting->getValue();
        };

        return $currentSettings;
    }

    /**
     * Load settings for the current user.
     *
     * First the default data is loaded,
     * which is bound to the user NULL in the database.
     * Then the user settings override those defaults.
     *
     * @param SettingRepositoryInterface $settingsRepository
     *
     * @return array
     */
    protected function getCurrentSettings($settingsRepository)
    {
        // get defaults / settings for user NULL as array
        $searchSettings  = new Setting();
        $currentSettings = $this->flattenSettings($settingsRepository->findAllSimilar($searchSettings));

        if ($this->getUser()) {
            // user is logged in => override default with the user settings
            $searchSettings->setUser($this->getUser());
            $userSettings = $this->flattenSettings($settingsRepository->findAllSimilar($searchSettings));

            $currentSettings = array_merge($currentSettings, $userSettings);
        }

        return $currentSettings;
    }

    /**
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        $this->get('crmp.setting.repository');
    }
}
