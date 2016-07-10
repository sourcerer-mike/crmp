<?php

namespace AppBundle\Menu;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Interface for the creation of menus by other bundles.
 *
 * @package AppBundle\Menu
 */
interface MenuInterface
{
    /**
     * Add entries to the main menu.
     *
     * @param RequestStack $requestStack
     *
     * @return mixed
     */
    public function createMainMenu(RequestStack $requestStack);

    /**
     * Add context menus.
     *
     * @param RequestStack $requestStack
     *
     * @return mixed
     */
    public function createRelatedMenu(RequestStack $requestStack);
}
