<?php

namespace Crmp\CrmBundle\Tests\Twig;

use Crmp\CrmBundle\Twig\AddressPanel;
use Crmp\CrmBundle\Twig\PanelGroup;
use Crmp\CrmBundle\Twig\PanelInterface;
use Symfony\Component\DependencyInjection\Container;

class PanelGroupTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanAddChildren()
    {
        $panelGroup = new PanelGroup();
        $panelGroup->setContainer(new Container());

        $panelMock = $this->getMockBuilder(AddressPanel::class)
                          ->disableOriginalConstructor()
                          ->getMock();

        $panelMock->expects($this->once())
                  ->method('setContainer');

        $panelGroup->add($panelMock);

        $this->assertEquals(1, $panelGroup->count());

        var_dump(iterator_to_array($panelGroup->getIterator()));
        $this->assertEquals(
            [$panelMock->getId() => $panelMock],
            iterator_to_array($panelGroup->getIterator())
        );
    }

    public function testPanelsCanBeRemoved()
    {

    }
}