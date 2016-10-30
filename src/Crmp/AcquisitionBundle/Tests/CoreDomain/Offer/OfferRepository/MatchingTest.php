<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository;


use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractRepositoryTestCase;
use Doctrine\ORM\EntityManager;

class MatchingTest extends AbstractRepositoryTestCase
{
    public function testItCanFilterByCustomer()
    {
        $expectedCustomer = new Customer();
        $expectedCustomer->setName(uniqid());

        $offer = new Offer();
        $offer->setCustomer($expectedCustomer);

        $offerRepositoryMock = $this->getRepositoryMock();

        $this->expectCriteria($offerRepositoryMock, 'customer', $expectedCustomer);

        $offerRepo = new OfferRepository($offerRepositoryMock, $this->createMock(EntityManager::class));
        $offerRepo->findSimilar($offer);
    }

    public function testItCanFilterByInquiry()
    {
        $expectedInquiry = new Inquiry();
        $expectedInquiry->setTitle(uniqid());

        $offer = new Offer();
        $offer->setInquiry($expectedInquiry);

        $offerRepositoryMock = $this->getRepositoryMock();

        $this->expectCriteria($offerRepositoryMock, 'inquiry', $expectedInquiry);

        $offerRepo = new OfferRepository($offerRepositoryMock, $this->createMock(EntityManager::class));

        $offerRepo->findSimilar($offer);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRepositoryMock()
    {
        return $this->getMockBuilder(\Crmp\AcquisitionBundle\Repository\OfferRepository::class)
                    ->disableOriginalConstructor()
                    ->setMethods(['matching'])
                    ->getMock();
    }
}