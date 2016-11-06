<?php

namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Offer\OfferRepository;

use Crmp\AcquisitionBundle\CoreDomain\Offer\OfferRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;

class FindAllSimilarTest extends AbstractFindAllSimilarTestCase
{
    public function testItCanFilterByCustomer()
    {
        $offer = new Offer();

        $customer = new Customer();
        $customer->setName(uniqid());

        $offer->setCustomer($customer);

        $this->assertFilteredBy('customer', $customer, $offer);
    }

    public function testItCanFilterByInquiry()
    {
        $offer = new Offer();

        $inquiry = new Inquiry();
        $inquiry->setTitle(uniqid());

        $offer->setInquiry($inquiry);

        $this->assertFilteredBy('inquiry', $inquiry, $offer);
    }

    protected function createEntity()
    {
        return new Offer();
    }

    /**
     * Get the current class name.
     *
     * With 1.0.0 this method will become so that every test have to implement it.
     *
     * @return string
     */
    protected function getRepositoryClassName()
    {
        return OfferRepository::class;
    }
}