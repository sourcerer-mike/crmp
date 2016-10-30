<?php


namespace Crmp\CrmBundle\Tests\Controller\SettingsController;


use Crmp\CrmBundle\Controller\SettingsController;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see     SettingsController::indexAction()
 *
 * @package Crmp\CrmBundle\Tests\Controller\SettingsController
 */
class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = SettingsController::class;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|SettingsController
     */
    protected $controllerMock;

    public function testItShowsListOfSettings()
    {
        $this->expectRenderingWith('CrmpCrmBundle:Settings:index.html.twig');

        $this->controllerMock->indexAction(new Request());
    }
}