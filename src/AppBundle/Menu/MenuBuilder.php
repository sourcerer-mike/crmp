<?php

namespace AppBundle\Menu;

use AppBundle\Event\Menu\ConfigureMainMenuEvent;
use AppBundle\Event\Menu\ConfigureRelatedMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
