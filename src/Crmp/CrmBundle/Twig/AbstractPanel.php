<?php

namespace Crmp\CrmBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractPanel
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $data = null;

    public function getBody()
    {
        return '';
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * By default it sends no data to the template.
     *
     * @return array
     */
    public function getData()
    {
        return (array) $this->data;
    }

    /**
     * The default style is "default".
     *
     * @return string
     */
    public function getStyle()
    {
        return 'default';
    }

    public function getTemplate()
    {
        return 'CrmBundle::panel.html.twig';
    }
}