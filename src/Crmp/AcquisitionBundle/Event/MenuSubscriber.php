<?php

namespace Crmp\AcquisitionBundle\Event;


use AppBundle\Event\Menu\ConfigureMainMenuEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuSubscriber implements EventSubscriberInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigureMainMenuEvent::NAME => 'onConfigure',
        ];
    }

    /**
     * @param ConfigureMainMenuEvent $menuEvent
     */
    public function onConfigure(ConfigureMainMenuEvent $menuEvent)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return;
        }

        $menu = $menuEvent->getMenu();

        $acquisition = $menu->addChild('crmp.acquisition.menu');

        $acquisition->addChild('crmp.acquisition.menu.inquiry', ['route' => 'inquiry_index']);
        $acquisition->addChild('crmp.acquisition.menu.offer', ['route' => 'offer_index']);
        $acquisition->addChild('crmp.acquisition.menu.contract', ['route' => 'contract_index']);
    }
}