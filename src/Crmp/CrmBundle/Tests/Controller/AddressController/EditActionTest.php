<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use AppBundle\Entity\User;
use Crmp\CrmBundle\Controller\AddressController;
use Crmp\CrmBundle\CoreDomain\Address\AddressRepository;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Edit an address.
 *
 * Open a single address and click the edit link.
 *
 * @package Crmp\CrmBundle\Tests\Controller\AddressController
 */
class EditActionTest extends AbstractControllerTestCase
{
    public function testCreatesEditFormForCustomer()
    {
        $address = new Address();
        $address->setName('John Doe');
        $address->setMail('some@example.org');

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $this->createCreateFormMock()
             ->expects($this->atLeastOnce())
             ->method('isSubmitted')
             ->willReturn(false);

        $this->createDeleteFormMock();

        $this->expectRendering('address', $address, 'CrmpCrmBundle:Address:edit.html.twig');

        /** @var AddressController $controller */
        $controller->editAction($this->createMock(Request::class), $address);
    }

    public function testItDelegatesSaveOperations()
    {
        $address = new Address();
        $address->setName('John Doe');
        $address->setMail('some@example.org');

        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $controller->expects($this->atLeastOnce())
                   ->method('getUser')
                   ->willReturn(new User());

        $controller->expects($this->atLeastOnce())
                   ->method('get')
                   ->with('crmp.address.repository')
                   ->willReturn(
                       $repoMock = $this->createMock(AddressRepository::class)
                   );

        $repoMock->expects($this->once())
                 ->method('update')
                 ->with($address);

        $createFormMock = $this->createCreateFormMock();

        $createFormMock->expects($this->atLeastOnce())
                       ->method('isSubmitted')
                       ->willReturn(true);

        $createFormMock->expects($this->atLeastOnce())
                       ->method('isValid')
                       ->willReturn(true);

        /** @var AddressController $controller */
        $controller->editAction($this->createMock(Request::class), $address);
    }

    protected function setUp()
    {
        $this->controllerClass = AddressController::class;

        parent::setUp();

        $this->controllerBuilder->setMethods(
            [
                'createDeleteForm',
                'createForm',
                'render',
                'get',
                'getUser',
                'redirectToRoute',
            ]
        );

    }
}