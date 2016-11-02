<?php


namespace Crmp\AcquisitionBundle\Tests\Entity\Offer;


use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Doctrine\ORM\EntityManager;

/**
 * Checks how offers are found in database.
 *
 * @see     OfferRepository::find()
 *
 * @package Crmp\AcquisitionBundle\Tests\Entity\Offer
 */
class FindTest extends \PHPUnit_Framework_TestCase
{
    public function testItDelegatesTheSearchToDoctrine()
    {
        $doctrineRepo = $this->getMockBuilder(\Crmp\AcquisitionBundle\Repository\OfferRepository::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['find'])
                             ->getMock();

        $doctrineRepo->expects($this->once())
                     ->method('find')
                     ->with(42);

        $offerRepo = new OfferRepository($doctrineRepo, $this->createMock(EntityManager::class));

        $offerRepo->find(42);
    }
}
