<?php

namespace Crmp\CrmBundle\Twig;


class TestPanel extends AbstractPanel implements PanelInterface
{

    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId()
    {
        return 'unique_id';
    }

    /**
     * Return the name of this boardlet.
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Captain Caption';
    }

    /**
     * Return a description of the boardlet.
     *
     * @return string
     */
    public function getBody()
    {
        return 'some bla bla';
    }
}