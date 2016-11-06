<?php

namespace Crmp\CrmBundle\Menu;

use FOS\UserBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

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
     * @param MenuInterface $menu    The menu to fill.
     * @param User          $user    Current user
     * @param \ArrayObject  $context The current context in the view.
     */
    public function __construct(MenuInterface $menu, User $user, \ArrayObject $context = null);
}
