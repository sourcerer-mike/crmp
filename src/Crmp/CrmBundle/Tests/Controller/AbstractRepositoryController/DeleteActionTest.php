<?php


namespace Crmp\CrmBundle\Tests\Controller\AbstractRepositoryController;


use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractRepositoryController;
use Crmp\CrmBundle\CoreDomain\AbstractRepository;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class DeleteActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = StubRepositoryController::class;

    public function testItDelegatesDeletionToRepository()
    {
        $entityId = uniqid();

        $stubEntity = new StubEntity();
        $stubEntity->setSomething(uniqid());

        $repositoryMock = $this->getMockBuilder(StubRepository::class)
                               ->disableOriginalConstructor()
                               ->setMethods(['find', 'remove'])
                               ->getMock();

        $this->controllerMock->expects($this->atLeastOnce())
                             ->method('getMainRepository')
                             ->willReturn($repositoryMock);

        $repositoryMock->expects($this->once())
                       ->method('find')
                       ->with($entityId)
                       ->willReturn($stubEntity);

        $formMock = $this->expectDeleteForm($stubEntity);

        $formMock->expects($this->any())
                 ->method('isSubmitted')
                 ->willReturn(true);

        $formMock->expects($this->any())
                 ->method('isValid')
                 ->willReturn(true);

        $repositoryMock->expects($this->once())
                       ->method('remove')
                       ->with($stubEntity);

        $this->controllerMock->deleteAction(new Request(['id' => $entityId]));
    }
}
