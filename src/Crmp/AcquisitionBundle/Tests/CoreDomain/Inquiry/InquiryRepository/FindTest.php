<?php


namespace Crmp\AcquisitionBundle\Tests\CoreDomain\Inquiry\InquiryRepository;

use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Doctrine\ORM\EntityManager;

/**
 * Asserting that delegation of inquiry searches work correctly.
 *
 * @see     InquiryRepository::find()
 *
 * @package Crmp\AcquisitionBundle\Tests\CoreDomain\Inquiry\InquiryRepository
 */
class FindTest extends \PHPUnit_Framework_TestCase
{
    public function testItDelegatesTheSearchToDoctrine()
    {
        $repositoryMock = $this->getMockBuilder(\Crmp\AcquisitionBundle\Repository\InquiryRepository::class)
                              ->disableOriginalConstructor()
                              ->setMethods(['find'])
                              ->getMock();

        $repositoryMock->expects($this->atLeastOnce())->method('find')->with(42);

        $inquiryRepository = new InquiryRepository(
            $repositoryMock,
            $this->createMock(EntityManager::class)
        );

        $inquiryRepository->find(42);
    }
}
