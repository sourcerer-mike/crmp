<?php

namespace Crmp\CrmBundle\Twig;

use Crmp\CrmBundle\Controller\SettingsController;

/**
 * Abstract for settings panel.
 *
 * Single panels can be put into a PanelGroup to enhance the information about entities or other views.
 *
 * @see     PanelGroup
 * @see     PanelInterface
 * @see     SettingsController
 *
 * @package Crmp\CrmBundle\Twig
 */
abstract class AbstractSettingsPanel extends AbstractPanel
{
    /**
     * Get form for the view.
     *
     * @return \Symfony\Component\Form\FormView
     */
    public function getForm()
    {
        return $this->createFormBuilder()->getForm()->createView();
    }

    /**
     * Use panel-settings template to show the form.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'CrmpCrmBundle::panel-settings.html.twig';
    }

    /**
     * Generate the form for the settings.
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    abstract protected function createFormBuilder();

    /**
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    protected function getFormBuilder()
    {
        return $this->container->get('form.factory')->createBuilder();
    }
}
