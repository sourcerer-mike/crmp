<?php

namespace Crmp\CrmBundle\Tests\Controller\AbstractRepositoryController;

use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class ShowActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = StubRepositoryController::class;

    public function testItRendersTheEntity()
    {
        $expectedEntity = new StubEntity();
        $expectedEntity->setSomething(uniqid());

        $expectedId = uniqid();

        $repositoryMock = $this->getMockBuilder(StubRepository::class)
                               ->disableOriginalConstructor()
                               ->setMethods(['find'])
                               ->getMock();

        $this->expectDeleteForm($expectedEntity);

        $repositoryMock->expects($this->once())
                       ->method('find')
                       ->with($expectedId)
                       ->willReturn($expectedEntity);

        $this->controllerMock->expects($this->atLeastOnce())
                             ->method('getMainRepository')
                             ->willReturn($repositoryMock);

        $this->expectRenderingWith(
            StubRepositoryController::VIEW_SHOW,
            [
                StubRepositoryController::ENTITY_NAME => $expectedEntity,
            ]
        );

        $this->controllerMock->showAction(new Request(['id' => $expectedId]));
    }
}