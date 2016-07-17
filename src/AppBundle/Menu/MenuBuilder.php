<?php

namespace AppBundle\Menu;

use AppBundle\Event\Menu\ConfigureMainMenuEvent;
use AppBundle\Event\Menu\ConfigureRelatedMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Build up main and related menu.
 *
 * @package AppBundle\Menu
 */
class MenuBuilder implements MenuBuilderInterface
{
    /**
     * @var TraceableEventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * MenuBuilder constructor.
     *
     * @param FactoryInterface   $factory
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(FactoryInterface $factory, ContainerInterface $serviceContainer)
    {
        $this->factory         = $factory;
        $this->container       = $serviceContainer;
        $this->eventDispatcher = $serviceContainer->get('event_dispatcher');
    }

    /**
     * Create the main menu.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setDisplay(false);

        $this->eventDispatcher->dispatch(
            ConfigureMainMenuEvent::NAME,
            new ConfigureMainMenuEvent($this->factory, $menu)
        );

        return $menu;
    }

    /**
     * Create the related menu.
     *
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createRelatedMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setDisplay(false);

        $this->eventDispatcher->dispatch(
            ConfigureRelatedMenuEvent::NAME,
            new ConfigureRelatedMenuEvent($this->factory, $menu)
        );

        return $menu;
    }
}
