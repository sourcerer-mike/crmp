<?php

namespace Crmp\CrmBundle\Menu;

use FOS\UserBundle\Model\User;
use FOS\UserBundle\Model\UserInterface;
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
     * @var MenuBuilder
     */
    protected $menuBuilder;
    /**
     * Current context.
     *
     * Those variables were given to the view.
     *
     * @var \ArrayObject
     */
    protected $renderParams;

    /**
     * Storage with user inside.
     *
     * @var UserInterface|string
     */
    protected $user;

    /**
     * MenuBuilder constructor.
     *
     * @param MenuInterface $menu         The menu to decorate.
     * @param User          $user         Current user
     * @param \ArrayObject  $renderParams Parameters that are given to the current view.
     */
    public function __construct(MenuInterface $menu, $user = null, \ArrayObject $renderParams = null)
    {
        $this->menuBuilder  = $menu;
        $this->user         = $user;
        $this->renderParams = $renderParams;
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

    protected function getRenderParams()
    {
        return $this->renderParams;
    }

    /**
     * @return null|User
     */
    protected function getUser()
    {
        return $this->user;
    }
}
