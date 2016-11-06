<?php

namespace Crmp\CrmBundle\Tests\Controller\CustomerController;


use Crmp\CrmBundle\Controller\CustomerController;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Component\HttpFoundation\Request;

class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = CustomerController::class;
    public function testItListsCustomers()
    {
        $this->expectRenderingWith('CrmpCrmBundle:Customer:index.html.twig');

        $this->expectFindAllSimilar(new Customer());

        $this->controllerMock->indexAction(new Request([]));
    }
}
