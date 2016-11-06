<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\CrmBundle\Panels\Settings\General;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * General controller layer for CRMP.
 *
 * @package Crmp\CrmBundle\Controller
 */
abstract class AbstractController extends Controller
{
    protected function getListLimit()
    {
        return $this->get('crmp.setting.repository')->get(General::LIST_LIMIT, $this->getUser());
    }

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $this->container->get('crmp.controller.render.parameters')->exchangeArray($parameters);

        return parent::render($view, $parameters, $response);
    }
}
