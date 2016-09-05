<?php

namespace Crmp\AcquisitionBundle\Adapter;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * An adapter to the Doctrine ORM.
 *
 * @package Crmp\AcquisitionBundle\Adapter
 */
class Offer {
    protected $container;

    public function __construct(ContainerInterface $serviceContainer)
    {   
        $this->contaier = $serviceContainer;
    }

    /**
     * Store or update an offer in the database.
     *
     * @param $offer
     */
    public function persist(\Crmp\AcquisitionBundle\Entity\Offer $offer)
    {
        $this->getEntityManager()->persist($offer);

        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->contaier->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \Crmp\AcquisitionBundle\Repository\OfferRepository
     */
    private function getRepository()
    {
        return $this->getEntityManager()->getRepository('CrmpAcquisitionBundle:Offer');
    }

    public function delete(\Crmp\AcquisitionBundle\Entity\Offer $offer)
    {
        $this->getEntityManager()->remove($offer);

        return $this;
    }

    public function flush()
    {
        $this->getEntityManager()->flush();

        return $this;
    }
}