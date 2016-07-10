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
     * @param PanelInterface|string $panel
     *
     * @return $this
     */
    public function remove($panel)
    {
        if ($panel instanceof PanelInterface) {
            $panel = $panel->getId();
        }

        if (! is_scalar($panel)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid argument of type "%s".'.' Expected \\Crmp\\CrmBundle\\Twig\\PanelInterface or string containing the ID.',
                    Debug::getType($panel)
                )
            );
        }

        if (! isset($this->children[$panel])) {
            return $this;
        }

        unset($this->children[$panel]);

        return $this;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return $this
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }
}
