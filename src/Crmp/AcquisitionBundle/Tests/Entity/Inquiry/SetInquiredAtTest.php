<?php


namespace Crmp\AcquisitionBundle\Tests\Entity\Inquiry;


use Crmp\AcquisitionBundle\Entity\Inquiry;

/**
 * Inquiries can have a inquired at date.
 *
 * @package Crmp\AcquisitionBundle\Tests\Entity\Inquiry
 *
 * @see     Inquiry::setInquiredAt()
 */
class SetInquiredAtTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /Invalid date given/
     */
    public function testItThrowsExceptionOnWrongData()
    {
        $inquiry = new Inquiry();

        $inquiry->setInquiredAt(new \stdClass());
    }

    public function testItTurnsStringIntoDateTime()
    {
        $inquiry = new Inquiry();

        $inquiry->setInquiredAt('2016-10-28 20:21');

        $value = $inquiry->getInquiredAt();

        $this->assertInstanceOf(\DateTime::class, $value);

        $this->assertEquals($value->format('Y-m-d H:i:s'), '2016-10-28 20:21:00');
    }
}
