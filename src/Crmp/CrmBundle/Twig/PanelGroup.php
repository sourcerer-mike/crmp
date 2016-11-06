<?php

namespace Crmp\CrmBundle\Twig;

use Crmp\CrmBundle\Debug;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Panel container.
 *
 * Given mostly below the view for single entities to show other related information / panels.
 *
 * @package Crmp\CrmBundle\Twig
 */
class PanelGroup implements \IteratorAggregate
{
    protected $children = [];

    protected $container;

    /**
     * Append another panel.
     *
     * Add a panel with related information.
     *
     * @param PanelInterface $panel
     *
     * @return $this
     */
    public function add(PanelInterface $panel)
    {
        $panel->setContainer($this->container);
        $this->children[$panel->getId()] = $panel;

        return $this;
    }

    /**
     * Amount of panels.
     *
     * @return int The amount of panels within this group.
     */
    public function count()
    {
        return (int) count($this->children);
    }

    /**
     * @return PanelInterface[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

    /**
     * @param ContainerInterface $container
     *
     * @deprecated 1.0.0 Every panel get their own container so this one is no longer needed.
     * @@codeCoverageIgnore
     *
     * @return $this
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }
}
