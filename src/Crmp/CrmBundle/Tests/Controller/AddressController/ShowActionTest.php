<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Controller\AddressController;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    protected function setUp()
    {
        $this->controllerClass = AddressController::class;

        parent::setUp();
    }

    public function testUserCanAccessTheList()
    {
        /** @var Address $someAddress */
        $someAddress = new Address();
        $someAddress->setName(uniqid());
        $someAddress->setMail(uniqid());

        $this->expectRendering('address', $someAddress, 'CrmpCrmBundle:Address:show.html.twig');

        $this->controllerMock->showAction($someAddress);
    }
}