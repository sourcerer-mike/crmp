<?php

namespace Crmp\CrmBundle\Tests\CoreDomain\Customer\CustomerRepository;

use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;
use Doctrine\ORM\EntityManager;

/**
 * Test the adapter to doctrine for finding customers.
 *
 * @see     CustomerRepository::find()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Customer
 */
class FindAllSimilarTest extends AbstractFindAllSimilarTestCase
{
    protected function createEntity()
    {
        return new Customer();
    }

    /**
     * Get the current class name.
     *
     * @return string
     */
    protected function getRepositoryClassName()
    {
        return CustomerRepository::class;
    }
}
