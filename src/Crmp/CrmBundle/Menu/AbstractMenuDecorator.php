<?php

namespace Crmp\CrmBundle\Menu;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Interface for other bundles to enhance a menu tree.
 *
 * @see     MenuDecoratorInterface
 *
 * @package AppBundle\Menu
 */
abstract class AbstractMenuDecorator implements MenuDecoratorInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var MenuBuilder
     */
    protected $menuBuilder;

    /**
     * MenuBuilder constructor.
     *
     * @param MenuInterface      $menu      The menu to decorate.
     * @param ContainerInterface $container DI container.
     */
    public function __construct(MenuInterface $menu, ContainerInterface $container)
    {
        $this->menuBuilder = $menu;
        $this->container   = $container;
    }

    /**
     * Decorate the main menu.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface|mixed
     */
    public function createMainMenu(RequestStack $requestStack)
    {
        return $this->menuBuilder->createMainMenu($requestStack);
    }

    /**
     * Decorate the user menu.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface|mixed
     */
    public function createUserMenu(RequestStack $requestStack)
    {
        return $this->menuBuilder->createUserMenu($requestStack);
    }

    /**
     * Decorate the related menu.
     *
     * Based on the current request (e.g. "customer_show")
     * another method will be called if it exists.
     * It will be named as "build{route}RelatedMenu".
     *
     * ## Examples
     *
     * - customer_show => buildCustomerShowRelatedMenu
     *
     * @deprecated 2.0.0 Solve this via a different approach, more modular and single purpose principle.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface|mixed
     */
    public function createRelatedMenu(RequestStack $requestStack)
    {
        $menu = $this->menuBuilder->createRelatedMenu($requestStack);

        $method = ucwords($requestStack->getCurrentRequest()->get('_route'), '_');
        $method = substr($method, 4); // cut off "Crmp" from the bundle name
        $method = 'build'.str_replace('_', '', $method).'RelatedMenu';

        if (method_exists($this, $method)) {
            $this->$method($menu);
        }


        return $menu;
    }

    protected function getRenderParams()
    {
        return $this->container->get('crmp.controller.render.parameters');
    }
}
