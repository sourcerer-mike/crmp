<?php

namespace Crmp\CrmBundle\Menu;

use Crmp\CrmBundle\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Extend user menu for this bundle.
 *
 * @package Crmp\CrmBundle\Menu
 */
class UserMenu extends AbstractMenuDecorator
{
    /**
     * Add user menu to top menu.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface|mixed
     */
    public function createUserMenu(RequestStack $requestStack)
    {
        $menu = parent::createUserMenu($requestStack);

        /** @var User $user */
        $user = $this->getUser();

        if (! $user || 'anon.' == $user) {
            // not logged in, skip
            return $menu;
        }

        $userMenu = $menu->addChild(
            $user->getUsername(),
            [
                'labelAttributes' => [
                    'icon' => 'fa fa-user',
                ],
            ]
        );

        $userMenu->addChild('Settings', ['route' => 'crmp_crm_settings_index']);

        $userMenu->addChild('Profile', ['route' => 'fos_user_profile_edit']);
        $userMenu->addChild(
            '',
            [
                'attributes' => [
                    'class' => 'divider',
                ],
            ]
        );
        $userMenu->addChild('Logout', ['route' => 'fos_user_security_logout']);

        return $menu;
    }
}
