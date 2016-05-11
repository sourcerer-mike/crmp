<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CrmpController extends Controller
{
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $this->container->set('crmp.controller.render.parameters', $parameters);

        return parent::render($view, $parameters, $response);
    }

}