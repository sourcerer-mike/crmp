<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository;

use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Offer;
use Doctrine\ORM\EntityManager;

/**
 * Asserting that delegation of offer updates work correctly.
 *
 * @see     OfferRepository::update()
 *
 * @package Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository
 */
class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function testItDelegatesUpdatesToDoctrine()
    {
        $offer = new Offer();
        $offer->setPrice(44);
        $offer->setStatus(9000);
        $offer->setTitle('the title');

        $entityManager = $this->getMockBuilder(EntityManager::class)
                              ->disableOriginalConstructor()
                              ->setMethods(['persist'])
                              ->getMock();

        $entityManager->expects($this->atLeastOnce())->method('persist')->with($offer);

        $offerRepository = new OfferRepository(
            $this->createMock(\Crmp\AcquisitionBundle\Repository\OfferRepository::class),
            $entityManager
        );

        $offerRepository->update($offer);
    }
}
