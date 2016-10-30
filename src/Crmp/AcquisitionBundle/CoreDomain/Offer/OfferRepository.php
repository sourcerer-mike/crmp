<?php


namespace Crmp\AcquisitionBundle\CoreDomain\Offer;

use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Repository\OfferRepository as OfferRepo;
use Doctrine\Common\Collections\Criteria;
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
     * @param OfferRepo     $offerRepository Storage with offers.
     * @param EntityManager $entityManager   Entity manager to persist offers in it.
     */
    public function __construct(OfferRepo $offerRepository, EntityManager $entityManager)
    {
        $this->offerRepository = $offerRepository;
        $this->entitiyManager  = $entityManager;
    }

    /**
     * Fetch an offer from repository by ID.
     *
     * @param int $offerId ID of the requested offer.
     *
     * @return null|Offer
     */
    public function find($offerId)
    {
        return $this->offerRepository->find($offerId);
    }

    /**
     * Fetch offers similar to another one.
     *
     * @param Offer $offer
     *
     * @return mixed
     */
    public function findSimilar(Offer $offer)
    {
        $criteria = Criteria::create();

        if ($offer->getInquiry()) {
            $criteria->andWhere($criteria->expr()->eq('inquiry', $offer->getInquiry()));
        }

        if ($offer->getCustomer()) {
            $criteria->andWhere($criteria->expr()->eq('customer', $offer->getCustomer()));
        }

        return $this->offerRepository->matching($criteria);
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
