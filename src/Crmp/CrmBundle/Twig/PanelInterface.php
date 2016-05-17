<?php

namespace Crmp\CrmBundle\Twig;


interface PanelInterface
{
    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId();

    /**
     * Return the name of this panel.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Return a description of the panel.
     *
     * @return string
     */
    public function getBody();

    /**
     * Path to the twig template that shall be used.
     * 
     * Default: 'CrmBundle::panel.html.twig
     * 
     * @return mixed
     */
    public function getTemplate();

    /**
     * Data that shall be forwarded to the template.
     *
     * @return array
     */
    public function getData();

    /**
     * Style of the panel.
     * 
     * Bootstrap 3 provides ("panel-..."):
     * 
     * - default
     * - primary
     * - success
     * - info
     * - warning
     * - danger
     * 
     * @see http://getbootstrap.com/components/#panels
     * 
     * @return mixed
     */
    public function getStyle();
}