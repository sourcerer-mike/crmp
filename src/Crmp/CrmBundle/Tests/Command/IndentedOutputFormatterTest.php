<?php

namespace Crmp\CrmBundle\Tests\Command;


use Crmp\CrmBundle\Command\IndentedOutputFormatter;

class IndentedOutputFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testItNeverDecreasesTheLeverLowerThanZero()
    {
        $indentedOutputFormatter = new IndentedOutputFormatter();

        // Given the level should be zero
        $this->assertEquals(0, $indentedOutputFormatter->getLevel());

        // When I decrease the level
        $indentedOutputFormatter->decreaseLevel();

        // Then it should not be lower than zero
        $this->assertGreaterThanOrEqual(0, $indentedOutputFormatter->getLevel());
    }
}
