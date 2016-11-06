<?php

namespace Crmp\CrmBundle\Tests\Menu\UserMenu;

use Crmp\CrmBundle\Entity\User;
use Crmp\CrmBundle\Menu\MenuBuilder;
use Crmp\CrmBundle\Menu\UserMenu;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateUserMenuTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Knp\Menu\ItemInterface
     */
    protected $menu;
    protected $username = 'the_username';

    public function testAnonymousHasNoUserMenu()
    {
        $factory = new MenuFactory();

        $user = new User();
        $user->setUsername('anon.');

        $userMenu = new UserMenu(new MenuBuilder($factory, new Container()), $user);

        $menu = $userMenu->createUserMenu(new RequestStack());

        $this->assertEquals([], $menu->getChildren());
    }

    public function testItHasALogoutEntry()
    {
        $entries = $this->menu->getChild($this->username);
        $this->assertNotNull($entries);

        $this->assertInstanceOf(MenuItem::class, $entries->getChild('Logout'));
    }

    public function testItHasAProfileEntry()
    {
        $entries = $this->menu->getChild($this->username);
        $this->assertNotNull($entries);

        $this->assertInstanceOf(MenuItem::class, $entries->getChild('Profile'));
    }

    public function testItHasASettingsEntry()
    {
        $entries = $this->menu->getChild($this->username);
        $this->assertNotNull($entries);

        $this->assertInstanceOf(MenuItem::class, $entries->getChild('Settings'));
    }

    /**
     * Usual setup with valid user.
     */
    protected function setUp()
    {
        $factory = new MenuFactory();

        $user = new User();
        $user->setUsername($this->username);

        $userMenu = new UserMenu(new MenuBuilder($factory, new Container()), $user);

        $this->menu = $userMenu->createUserMenu(new RequestStack());

        parent::setUp();
    }
}