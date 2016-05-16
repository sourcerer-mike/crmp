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
}