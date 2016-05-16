<?php

namespace Crmp\CrmBundle\Twig;


class PanelGroup implements \IteratorAggregate
{
    protected $children = [];

    public function add(PanelInterface $panel)
    {
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
        unset( $this->children[$panel] );

        return $this;
    }
}