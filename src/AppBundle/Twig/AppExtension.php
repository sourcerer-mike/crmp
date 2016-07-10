<?php

namespace AppBundle\Twig;

/**
 * The app itself extending Twig.
 *
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    /**
     * Register filters.
     *
     * @see ::priceFilter
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    /**
     * Unique name for the Twig-Extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }

    /**
     * Turn a float into a price format.
     *
     * @param float  $number
     * @param int    $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return string
     */
    public function priceFilter($number, $decimals = 2, $decPoint = ',', $thousandsSep = '.')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.' EUR';

        return $price;
    }
}
