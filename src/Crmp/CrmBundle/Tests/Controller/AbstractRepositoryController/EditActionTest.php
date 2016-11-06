<?php


namespace Crmp\CrmBundle\Tests\Controller\AbstractRepositoryController;


use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class EditActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = StubRepositoryController::class;

    public function testItRedirectsOnSave()
    {
        $expectedEntity = new StubEntity();
        $expectedEntity->setSomething(uniqid());

        $editForm = $this->expectForm(StubRepositoryController::FORM_TYPE, $expectedEntity);

        $editForm->expects($this->once())
                 ->method('isSubmitted')
                 ->willReturn(true);

        $editForm->expects($this->once())
                 ->method('isValid')
                 ->willReturn(true);

        $providedId = uniqid();

        $repositoryMock = $this->getMockBuilder(StubRepository::class)
                               ->disableOriginalConstructor()
                               ->setMethods(['find', 'persist'])
                               ->getMock();

        $repositoryMock->expects($this->once())
                       ->method('find')
                       ->with($providedId)
                       ->willReturn($expectedEntity);

        $repositoryMock->expects($this->once())
                       ->method('persist')
                       ->with($expectedEntity);

        $this->controllerMock->expects($this->atLeastOnce())
                             ->method('getMainRepository')
                             ->willReturn($repositoryMock);

        $this->expectRedirectToRoute(StubRepositoryController::ROUTE_SHOW, ['id' => $expectedEntity->getId()]);

        $this->controllerMock->editAction(new Request(['id' => $providedId]));
    }

    public function testItRendersAnEditForm()
    {
        $expectedEntity = new StubEntity();
        $expectedEntity->setSomething(uniqid());

        $expectedFormView       = uniqid();
        $expectedDeleteFormView = uniqid();

        $editForm = $this->expectForm(StubRepositoryController::FORM_TYPE, $expectedEntity);
        $editForm->expects($this->once())
                 ->method('createView')
                 ->willReturn($expectedFormView);

        $deleteForm = $this->expectDeleteForm($expectedEntity);
        $deleteForm->expects($this->once())
                   ->method('createView')
                   ->willReturn($expectedDeleteFormView);

        $providedId = uniqid();

        $repositoryMock = $this->getMockBuilder(StubRepository::class)
                               ->disableOriginalConstructor()
                               ->setMethods(['find', 'persist'])
                               ->getMock();

        $repositoryMock->expects($this->once())
                       ->method('find')
                       ->with($providedId)
                       ->willReturn($expectedEntity);

        $this->controllerMock->expects($this->atLeastOnce())
                             ->method('getMainRepository')
                             ->willReturn($repositoryMock);

        $this->expectRenderingWith(
            StubRepositoryController::VIEW_EDIT,
            [
                'edit_form'   => $expectedFormView,
                'delete_form' => $expectedDeleteFormView,
            ]
        );

        $this->controllerMock->editAction(new Request(['id' => $providedId]));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please provide an ID.
     */
    public function testItThrowsExceptionWhenNoIdIsGiven()
    {
        $this->controllerMock->editAction(new Request());
    }
}