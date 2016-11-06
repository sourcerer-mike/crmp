<?php

namespace Crmp\CrmBundle\Tests\Twig;

use Crmp\CrmBundle\Twig\PriceRenderer;

class PriceRendererTest extends \PHPUnit_Framework_TestCase
{
    public function getInOutValues()
    {
        return [
            [1, '1,00 EUR'],
            [-1, '-1,00 EUR'],
            [1.0049, '1,00 EUR'],
            [1.005, '1,01 EUR'],
        ];
    }

    /**
     * @dataProvider getInOutValues
     */
    public function testItFormatsToPrice($input, $expectedOutput)
    {
        $priceRenderer = new PriceRenderer();

        $this->assertEquals($expectedOutput, $priceRenderer->priceFilter($input));
    }

    public function testItHasAName()
    {
        $priceRenderer = new PriceRenderer();

        $this->assertEquals('crmp_crm_price', $priceRenderer->getName());
    }

    public function testItRegistersTheKeywordPrice()
    {
        $priceRenderer = new PriceRenderer();

        $filters = $priceRenderer->getFilters();

        /** @var \Twig_SimpleFilter $simpleFilter */
        $simpleFilter = $filters[0];

        $this->assertEquals('price', $simpleFilter->getName());
        $this->assertEquals([$priceRenderer, 'priceFilter'], $simpleFilter->getCallable());
    }
}