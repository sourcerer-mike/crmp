<?php

namespace Crmp\CrmBundle\Panels\Settings;

use Crmp\CrmBundle\Twig\AbstractSettingsPanel;
use Crmp\CrmBundle\Twig\PanelInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\GreaterThan;

/**
 * General settings for CrmBundle.
 *
 * @package Crmp\CrmBundle\Panels\Settings
 */
class General extends AbstractSettingsPanel implements PanelInterface
{
    const LIST_LIMIT = 'general:list_limit';

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'crmp_crm.settings.general';
    }

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container->get('translator')->trans('crmp_crm.settings.general');
    }

    /**
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    protected function createFormBuilder()
    {
        $formBuilder = $this->getFormBuilder();

        // Maximum number of items in a list (per page).
        $formBuilder->add(
            static::LIST_LIMIT,
            IntegerType::class,
            [
                'attr'        => [
                    'min' => 1,
                    'max' => 100,
                ],
                'constraints' => [
                    new GreaterThan(0),
                ],
                'label'       => $this->container->get('translator')->trans('crmp_crm.settings.list_limit'),
            ]
        );

        return $formBuilder;
    }
}
