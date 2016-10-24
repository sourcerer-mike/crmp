<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository;


use Crmp\AcquisitionBundle\Entity\Offer;
use Doctrine\ORM\EntityManager;

abstract class AbstractRepositoryTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Mock entity manager.
     *
     * @param string $string Method name.
     * @param Offer  $offer  Expected offer.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function expectEntityManagerCall($string, $offer)
    {
        $entityManager = $this->getMockBuilder(EntityManager::class)
                              ->disableOriginalConstructor()
                              ->setMethods([$string])
                              ->getMock();

        $entityManager->expects($this->atLeastOnce())->method($string)->with($offer);

        return $entityManager;
    }

    /**
     * Create offer stub.
     *
     * @return Offer
     */
    protected function getOfferStub()
    {
        $offer = new Offer();
        $offer->setPrice(44);
        $offer->setStatus(9000);
        $offer->setTitle('the title');

        return $offer;
    }
}