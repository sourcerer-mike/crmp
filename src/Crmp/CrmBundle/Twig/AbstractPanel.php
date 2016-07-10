<?php

namespace Crmp\CrmBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractPanel
{
    const STYLE_DANGER  = 'danger';
    const STYLE_DEFAULT = 'default';
    const STYLE_INFO    = 'info';
    const STYLE_PRIMARY = 'primary';
    const STYLE_SUCCESS = 'success';
    const STYLE_WARNING = 'warning';
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
        return 'CrmpCrmBundle::panel.html.twig';
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
