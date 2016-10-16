<?php

namespace Crmp\CrmBundle\Tests\CoreDomain\Address\AddressRepository;

use Crmp\CrmBundle\CoreDomain\Address\AddressRepository;
use Crmp\CrmBundle\Entity\Address;
use Doctrine\ORM\EntityManager;

/**
 * Testing the doctrine adapter for addresses.
 *
 * @see     AddressRepository::update()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Address\AddressRepository
 */
class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function testItForwardsUpdatesToDoctrine()
    {
        $address = new Address();
        $address->setName('John Doe');
        $address->setMail('some@example.org');

        $entityManager = $this->getMockBuilder(EntityManager::class)
                              ->disableOriginalConstructor()
                              ->setMethods(['persist'])
                              ->getMock();

        $entityManager->expects($this->once())
                      ->method('persist')
                      ->with($address);

        $addressRepository = new AddressRepository(
            $this->createMock(\Crmp\CrmBundle\Repository\AddressRepository::class),
            $entityManager
        );


        /** @var AddressRepository */
        $addressRepository->update($address);
    }
}
