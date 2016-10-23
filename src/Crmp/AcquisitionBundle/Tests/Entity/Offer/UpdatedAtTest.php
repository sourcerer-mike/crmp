<?php


namespace Crmp\AcquisitionBundle\Tests\Entity\Offer;


use Crmp\AcquisitionBundle\Entity\Offer;

class UpdatedAtTest extends \PHPUnit_Framework_TestCase
{
    public function testItContainsDate()
    {
        $offer = new Offer();

        $updatedAt = new \DateTime('last week');

        $offer->setUpdatedAt($updatedAt);

        $this->assertEquals($updatedAt, $offer->getUpdatedAt());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /can not be in the future/
     */
    public function testItThrowsExceptionWhenDateIsInDistantFuture()
    {
        $offer = new Offer();

        $offer->setUpdatedAt(new \DateTime('+3 days'));
    }

    public function testItUpdatesTheChangeDateBeforeEverySave()
    {
        $offer = new Offer();

        $this->assertNull($offer->getUpdatedAt());

        $oldDate = new \DateTime('-1 minute');
        $offer->setUpdatedAt($oldDate);
        $this->assertNotNull($offer->getUpdatedAt());

        $offer->doPreUpdate();

        $this->assertNotEquals($oldDate, $offer->getUpdatedAt());
        $this->assertGreaterThan(time() - 3, $offer->getUpdatedAt()->getTimestamp());
        $this->assertLessThan(time() + 3, $offer->getUpdatedAt()->getTimestamp());
    }
}