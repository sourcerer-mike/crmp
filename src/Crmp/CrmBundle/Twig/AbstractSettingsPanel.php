<?php

namespace Crmp\CrmBundle\Twig;

use Crmp\CrmBundle\Controller\SettingsController;
use Symfony\Component\Form\FormInterface;

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
     * Transient form instance.
     *
     * The form needs to be stored in memory
     * and reused because it shall gather error messages.
     *
     * @var FormInterface
     */
    private $form;

    /**
     * Get form for the view.
     *
     * @return \Symfony\Component\Form\FormView
     */
    public function getForm()
    {
        if (! $this->form) {
            $this->form = $this->createFormBuilder()->getForm();
        }

        return $this->form->createView();
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
        // TODO 1.0.0 Inject the builder via some other way (constructor or setter).
        return $this->container->get('form.factory')->createBuilder();
    }
}
