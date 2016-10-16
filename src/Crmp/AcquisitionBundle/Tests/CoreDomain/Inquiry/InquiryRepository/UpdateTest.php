<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Inquiry\InquiryRepository;

use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Doctrine\ORM\EntityManager;

/**
 * Asserting that delegation of inquiry updates work correctly.
 *
 * @see     InquiryRepository::update()
 *
 * @package Crmp\AcquisitionBundle\Tests\CoreDomain\Inquiry\InquiryRepository
 */
class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function testItDelegatesUpdatesToDoctrine()
    {
        $inquiry = new Inquiry();
        $inquiry->setStatus(-5);
        $inquiry->setTitle('inquiry title');
        $inquiry->setContent('some content');

        $entityManager = $this->getMockBuilder(EntityManager::class)
                              ->disableOriginalConstructor()
                              ->setMethods(['persist'])
                              ->getMock();

        $entityManager->expects($this->atLeastOnce())->method('persist')->with($inquiry);

        $inquiryRepository = new InquiryRepository(
            $this->createMock(\Crmp\AcquisitionBundle\Repository\InquiryRepository::class),
            $entityManager
        );

        $inquiryRepository->update($inquiry);
    }
}
