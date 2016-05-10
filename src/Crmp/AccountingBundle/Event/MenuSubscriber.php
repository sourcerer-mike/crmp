<?php

namespace Crmp\AccountingBundle\Event;


use AppBundle\Event\Menu\ConfigureMainMenuEvent;
use AppBundle\Event\Menu\ConfigureRelatedMenuEvent;
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
            ConfigureMainMenuEvent::NAME    => 'onMainConfigure',
            ConfigureRelatedMenuEvent::NAME => 'onRelatedConfigure',
        ];
    }

    /**
     * @param ConfigureMainMenuEvent $menuEven
     */
    public function onMainConfigure(ConfigureMainMenuEvent $menuEvent)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ('anon.' == $user) {
            // not logged in, skip
            return;
        }

        $menu = $menuEvent->getMenu();

        $acquisition = $menu->addChild('Accounting');

        $acquisition->addChild('Invoice', ['route' => 'invoice_index']);
    }

    public function onRelatedConfigure(ConfigureRelatedMenuEvent $relatedEvent)
    {
        $route = $this->container->get('request_stack')->getCurrentRequest()->get('_route');
        $menu  = $relatedEvent->getMenu();

        switch ($route) {
            case 'contract_show':
                // Create invoice based on current contract
                $menu->addChild(
                    'crmp.accounting.invoice.create',
                    [
                        'route'     => 'invoice_new',
                        'routeParameters' => [
                            'customer' => 1,
                        ],
                        'labelAttributes' => [
                            'icon' => 'fa fa-plus'
                        ],
                    ]
                );
                break;
        }
    }
}