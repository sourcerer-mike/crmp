<?php

namespace Crmp\CrmBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

class PanelGroup implements \IteratorAggregate
{
    protected $children = [];

    protected $container;

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

    public function add(PanelInterface $panel)
    {
        $panel->setContainer($this->container);
        $this->children[$panel->getId()] = $panel;

        return $this;
    }

    public function count()
    {
        return count($this->children);
    }

    /**
     * @return PanelInterface[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

    public function remove(PanelInterface $panel)
    {
        unset( $this->children[$panel->getId()] );

        return $this;
    }
}