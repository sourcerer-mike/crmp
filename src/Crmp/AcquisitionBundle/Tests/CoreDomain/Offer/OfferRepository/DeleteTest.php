<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository;

use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Offer;
use Doctrine\ORM\EntityManager;

/**
 * Asserting that delegation of offer deletion work correctly.
 *
 * @see     OfferRepository::delete()
 *
 * @package Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository
 */
class DeleteTest extends AbstractRepositoryTestCase
{
    public function testItDelegatesDeletionToDoctrine()
    {
        $offer = $this->getOfferStub();

        $entityManager = $this->expectEntityManagerCall('remove', $offer);

        $offerRepository = new OfferRepository(
            $this->createMock(\Crmp\AcquisitionBundle\Repository\OfferRepository::class),
            $entityManager
        );

        $offerRepository->delete($offer);
    }
}
