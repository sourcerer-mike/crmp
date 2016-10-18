<?php

namespace Crmp\CrmBundle\Tests\CoreDomain\Customer;

use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Doctrine\ORM\EntityManager;

/**
 * Test the adapter to doctrine for finding customers.
 *
 * @see     CustomerRepository::find()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Customer
 */
class FindTest extends \PHPUnit_Framework_TestCase
{
    public function testItDelegatesToTheDoctrineRepository()
    {
        $customerId = mt_rand(4, 9001);

        $doctrineRepository = $this->getMockBuilder(\Crmp\CrmBundle\Repository\CustomerRepository::class)
                                   ->disableOriginalConstructor()
                                   ->setMethods(['find'])
                                   ->getMock();

        // Assert that the delegation happens
        $doctrineRepository->expects($this->once())
                           ->method('find')
                           ->with($customerId);

        $entityManager = $this->getMockBuilder(EntityManager::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $customerRepository = new CustomerRepository($doctrineRepository, $entityManager);

        $customerRepository->find($customerId);
    }
}
