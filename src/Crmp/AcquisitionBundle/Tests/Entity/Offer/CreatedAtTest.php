<?php


namespace Crmp\AcquisitionBundle\Tests\Entity\Offer;


use Crmp\AcquisitionBundle\Entity\Offer;

class CreatedAtTest extends \PHPUnit_Framework_TestCase
{
    public function testItUpdatesTheChangeDateBeforeEverySave()
    {
        $offer = new Offer();

        $this->assertNull($offer->getCreatedAt());

        $offer->doPrePersist();

        $this->assertGreaterThan(time() - 2, $offer->getCreatedAt()->getTimestamp());
        $this->assertLessThan(time() + 2, $offer->getCreatedAt()->getTimestamp());
    }
}