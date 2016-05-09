<?php

namespace AppBundle\Menu;


use AppBundle\Event\ConfigureMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

class MenuBuilder
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
     * @param FactoryInterface $factory
     * @param Container        $serviceContainer
     */
    public function __construct(FactoryInterface $factory, $serviceContainer)
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
            ConfigureMenuEvent::CONFIGURE,
            new ConfigureMenuEvent($this->factory, $menu)
        );

        return $menu;
    }
}