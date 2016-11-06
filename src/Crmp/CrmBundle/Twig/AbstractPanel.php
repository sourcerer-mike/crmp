<?php

namespace Crmp\CrmBundle\Twig;

use Crmp\CoreDomain\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Abstract for single panels.
 *
 * Single panels can be put into a PanelGroup to enhance the information about entities or other views.
 *
 * @see     PanelGroup
 * @see     PanelInterface
 *
 * @package Crmp\CrmBundle\Twig
 */
abstract class AbstractPanel
{
    const STYLE_DANGER  = 'danger';
    const STYLE_DEFAULT = 'default';
    const STYLE_INFO    = 'info';
    const STYLE_PRIMARY = 'primary';
    const STYLE_SUCCESS = 'success';
    const STYLE_WARNING = 'warning';
    /**
     * Data for the template.
     *
     * This data will be filled with the current context
     * and given to the template as "data".
     *
     * @param
     */
    protected $data;
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Inject current context.
     *
     * @since 1.0.0 The constructor arguments are no longer optional.
     *
     * @param RepositoryInterface $repository   The main repository.
     * @param \ArrayObject        $renderedData Current context / data given from controller to the view.
     */
    public function __construct(
        RepositoryInterface $repository = null,
        \ArrayObject $renderedData = null
    ) {
        $this->repository = $repository;
        $this->data       = $renderedData;
    }

    /**
     * Body of the panel.
     *
     * @see http://getbootstrap.com/components/#panels
     *
     * @return string
     */
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

    /**
     * Default template for panels.
     *
     * @return string Path to panel template.
     */
    public function getTemplate()
    {
        return 'CrmpCrmBundle::panel.html.twig';
    }

    /**
     * All lists are visible by default.
     *
     * @return bool
     */
    public function isVisible()
    {
        return true;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
