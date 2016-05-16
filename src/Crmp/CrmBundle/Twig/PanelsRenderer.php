<?php

namespace Crmp\CrmBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

class PanelsRenderer extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('crmp_panels', [$this, 'render']),
        ];
    }

    public function render(PanelGroup $panel)
    {
        foreach ($panel->getIterator() as $item) {
            var_dump($item->getBody(), $item->getId());
        }
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
}