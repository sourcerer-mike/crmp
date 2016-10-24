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
class UpdateTest extends AbstractRepositoryTestCase
{
    public function testItDelegatesUpdatesToDoctrine()
    {
        $offer = $this->getOfferStub();

        $entityManager = $this->expectEntityManagerCall('persist', $offer);

        $offerRepository = new OfferRepository(
            $this->createMock(\Crmp\AcquisitionBundle\Repository\OfferRepository::class),
            $entityManager
        );

        $offerRepository->update($offer);
    }
}
