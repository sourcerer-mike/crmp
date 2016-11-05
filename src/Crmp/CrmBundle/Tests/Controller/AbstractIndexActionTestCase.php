<?php


namespace Crmp\CrmBundle\Tests\Controller;


use Crmp\CrmBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractIndexActionTestCase extends AbstractControllerTestCase
{
    protected function assertFiltering(
        $relatedEntity,
        $relatedRepositoryClass,
        $relatedRepositoryService,
        $filterEntity,
        $view,
        $filterName,
        $relatedEntityName
    ) {
        $entityId = mt_rand(42, 1337);

        $filterEntityRepository = $this->getMockBuilder($relatedRepositoryClass)
                                       ->disableOriginalConstructor()
                                       ->setMethods(['find'])
                                       ->getMock();

        $filterEntityRepository->expects($this->any())
                               ->method('find')
                               ->with($entityId)
                               ->willReturn($relatedEntity);

        $this->mockService($relatedRepositoryService, $filterEntityRepository);

        $expectedSet = [uniqid()];
        $this->expectFindAllSimilar($filterEntity)->willReturn($expectedSet);

        $this->expectRenderingWith($view, [$filterName => $expectedSet]);

        $this->controllerMock->indexAction(new Request([$relatedEntityName => $entityId]));
    }
}