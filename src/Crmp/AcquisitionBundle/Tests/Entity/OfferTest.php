<?php

namespace Crmp\AcquisitionBundle\Tests\Entity;

use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Entity\Customer;

class OfferTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanBeBoundToACustomer()
    {
        $offer = new Offer();

        $customer = new Customer();
        $customer->setName(uniqid());

        $offer->setCustomer($customer);

        $this->assertEquals($customer, $offer->getCustomer());
    }

    public function testItCanBeBoundToAnInquiry()
    {
        $offer = new Offer();

        $inquiry = new Inquiry();
        $inquiry->setTitle(uniqid());

        $offer->setInquiry($inquiry);

        $this->assertEquals($inquiry, $offer->getInquiry());

    }

    public function testItHasAPrice()
    {
        $offer = new Offer();

        $price = 1337;
        $offer->setPrice($price);

        $this->assertEquals($price, $offer->getPrice());
    }

    public function testItHasAStatus()
    {
        $offer = new Offer();

        $status = 42;
        $offer->setStatus($status);

        $this->assertEquals($status, $offer->getStatus());
    }

    public function testItHasATitle()
    {
        $offer = new Offer();

        $title = uniqid();
        $offer->setTitle($title);

        $this->assertEquals($title, $offer->getTitle());
    }

    public function testItHasContent()
    {
        $offer = new Offer();

        $content = uniqid();
        $offer->setContent($content);

        $this->assertEquals($content, $offer->getContent());
    }

    public function testItStoresItCreationDate()
    {
        $offer = new Offer();

        $offer->doPrePersist();

        $this->assertGreaterThan(time() - 2, $offer->getCreatedAt()->getTimestamp());
        $this->assertLessThanOrEqual(time() + 2, $offer->getCreatedAt()->getTimestamp());
    }

    public function testItStoresWhenItIsUpdated()
    {
        $offer = new Offer();

        $offer->doPreUpdate();

        $this->assertGreaterThan(time() - 2, $offer->getUpdatedAt()->getTimestamp());
        $this->assertLessThanOrEqual(time() + 2, $offer->getUpdatedAt()->getTimestamp());
    }
}