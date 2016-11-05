<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Inquiry\InquiryRepository;

use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;
use Doctrine\ORM\EntityManager;

/**
 * Asserting that delegation of inquiry searches work correctly.
 *
 * @see     InquiryRepository::find()
 *
 * @package Crmp\AcquisitionBundle\Tests\CoreDomain\Inquiry\InquiryRepository
 */
class FindAllSimilarTest extends AbstractFindAllSimilarTestCase
{
    public function testItCanFilterByCustomer()
    {
        $customer = new Customer();
        $customer->setName(uniqid());

        $inquiry = new Inquiry();
        $inquiry->setCustomer($customer);

        $this->assertFilteredBy('customer', $customer, $inquiry);
    }

    public function testItCanFilterByStatus()
    {
        $status = mt_rand(42,1337);

        $inquiry = $this->createEntity();
        $inquiry->setStatus($status);

        $this->assertFilteredBy('status', $status, $inquiry);
    }

    protected function createEntity()
    {
        return new Inquiry();
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
        return InquiryRepository::class;
    }
}
