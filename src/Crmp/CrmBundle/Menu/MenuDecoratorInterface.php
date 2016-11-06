<?php

namespace Crmp\CrmBundle\Menu;

use FOS\UserBundle\Model\UserInterface;

/**
 * Interface for other bundles to enhance a menu tree.
 *
 * @see     AbstractMenuDecorator
 *
 * @package AppBundle\Menu
 */
interface MenuDecoratorInterface extends MenuInterface
{
    /**
     * MenuDecoratorInterface constructor.
     *
     * @param MenuInterface        $menu    The menu to fill.
     * @param UserInterface|string $user    Current user
     * @param \ArrayObject         $context The current context in the view.
     */
    public function __construct(MenuInterface $menu, $user, \ArrayObject $context = null);
}
