<?php


namespace Crmp\AcquisitionBundle\CoreDomain\Offer;

use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Repository\OfferRepository as OfferRepo;
use Doctrine\ORM\EntityManager;

/**
 * Adapter to doctrine for managing offers.
 *
 * @package Crmp\AcquisitionBundle\CoreDomain\Offer
 */
class OfferRepository
{
    /**
     * Inject interfaces to doctrine.
     *
     * @param OfferRepository $offerRepository Storage with offers.
     * @param EntityManager   $entityManager   Entity manager to persist offers in it.
     */
    public function __construct(OfferRepo $offerRepository, EntityManager $entityManager)
    {
        $this->offerRepository = $offerRepository;
        $this->entitiyManager  = $entityManager;
    }

    /**
     * Remove an offer from the repo.
     *
     * @param Offer $offer
     */
    public function delete(Offer $offer)
    {
        $this->entitiyManager->remove($offer);
    }

    /**
     * Change offer data in the storage.
     *
     * @param Offer $offer
     */
    public function update(Offer $offer)
    {
        $this->entitiyManager->persist($offer);
    }
}
