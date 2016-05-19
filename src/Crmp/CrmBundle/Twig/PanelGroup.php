<?php

namespace Crmp\CrmBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

class PanelGroup implements \IteratorAggregate
{
    protected $children = [];

    protected $container;

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

        if ( ! is_scalar($panel)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid argument of type "%s".'.
                    ' Expected \\Crmp\\CrmBundle\\Twig\\PanelInterface or string containing the ID.',
                    \Crmp\CrmBundle\Debug::get_type($panel)
                )
            );
        }

        if ( ! isset( $this->children[$panel] )) {
            return $this;
        }

        unset( $this->children[$panel] );

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