<?php

namespace Crmp\CrmBundle\Twig;

/**
 * Twig-Extension to render panels.
 *
 * @package Crmp\CrmBundle\Twig
 */
class PanelsRenderer extends \Twig_Extension
{
    protected $container;

    /**
     * Register the crmp_panels function for Twig.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'crmp_panels',
                [$this, 'render'],
                [
                    'is_safe' => ['html'],          // to not escape html entities
                    'needs_environment' => true,    // for access to the twig template
                ]
            ),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'crmp';
    }

    /**
     * Render all registered panels.
     *
     * Iterates over all registered panels and renders them.
     * The template will have a "panel" variable referencing the single PanelInterface instance.
     *
     * @param \Twig_Environment $twig
     * @param PanelGroup        $panelGroup
     *
     * @return string
     */
    public function render(\Twig_Environment $twig, PanelGroup $panelGroup)
    {
        $out = '';
        foreach ($panelGroup->getIterator() as $item) {
            $context = array_merge(['panel' => $item], (array) $item->getData());
            $out .= $twig->render($item->getTemplate(), $context);
        }

        return $out;
    }
}
