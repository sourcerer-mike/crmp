<?php

namespace Crmp\CrmBundle\Twig;


abstract class AbstractPanel
{
    public function getTemplate()
    {
        return 'CrmBundle::panel.html.twig';
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
     * By default it sends no data to the template.
     * 
     * @return array
     */
    public function getData()
    {
        return [];
    }
}