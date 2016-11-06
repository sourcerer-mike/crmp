<?php


namespace Crmp\CrmBundle\Tests\CoreDomain\Customer;

use \Crmp\CrmBundle\CoreDomain\Customer\Customer;
use Crmp\CrmBundle\Entity\Address;

/**
 * CustomerTest
 *
 * @see     \Crmp\CrmBundle\CoreDomain\Customer\Customer
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Customer
 */
class CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testItHasAName()
    {
        $customer = new Customer();

        $expectedName = uniqid();
        $customer->setName($expectedName);

        $this->assertEquals($expectedName, $customer->getName());
    }

    public function testItHasAddresses()
    {
        $customer = new Customer();

        $expectedSet = [uniqid()];
        $this->setProperty($customer, 'addresses', $expectedSet);

        $this->assertEquals($expectedSet, $customer->getAddresses());
    }

    public function testItHasInvoices()
    {
        $customer = new Customer();

        $expectedSet = [uniqid()];
        $this->setProperty($customer, 'invoices', $expectedSet);

        $this->assertEquals($expectedSet, $customer->getInvoices());
    }

    protected function setProperty($object, $property, $value)
    {
        $reflectObject      = new \ReflectionObject($object);
        $propertyReflection = $reflectObject->getProperty($property);

        $propertyReflection->setAccessible(true);
        $propertyReflection->setValue($object, $value);
    }
}