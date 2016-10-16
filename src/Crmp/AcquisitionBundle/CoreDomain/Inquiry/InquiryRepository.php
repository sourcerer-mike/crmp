<?php


namespace Crmp\AcquisitionBundle\CoreDomain\Inquiry;

use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Repository\InquiryRepository as InquiryRepo;
use Doctrine\ORM\EntityManager;

/**
 * Adapter to doctrine for managing inquirys.
 *
 * @package Crmp\AcquisitionBundle\CoreDomain\Inquiry
 */
class InquiryRepository
{
    /**
     * Inject interfaces to doctrine.
     *
     * @param InquiryRepository $inquiryRepository Storage with inquirys.
     * @param EntityManager   $entityManager   Entity manager to persist inquirys in it.
     */
    public function __construct(InquiryRepo $inquiryRepository, EntityManager $entityManager)
    {
        $this->inquiryRepository = $inquiryRepository;
        $this->entitiyManager  = $entityManager;
    }

    /**
     * Change inquiry data in the storage.
     *
     * @param Inquiry $inquiry
     */
    public function update(Inquiry $inquiry)
    {
        $this->entitiyManager->persist($inquiry);
    }
}
