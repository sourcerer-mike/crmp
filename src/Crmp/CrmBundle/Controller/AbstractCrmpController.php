<?php

namespace Crmp\CrmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract controller for CRMP.
 *
 * Other controller shall inherit from this
 * because it registers the current used parameters in the DI container.
 *
 * @package Crmp\CrmBundle\Controller
 */
abstract class AbstractCrmpController extends Controller
{
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $this->container->set('crmp.controller.render.parameters', $parameters);

        return parent::render($view, $parameters, $response);
    }
}
