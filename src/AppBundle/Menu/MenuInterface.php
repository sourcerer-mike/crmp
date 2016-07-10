<?php

namespace AppBundle\Menu;

use Symfony\Component\HttpFoundation\RequestStack;

interface MenuInterface
{
    public function createMainMenu(RequestStack $requestStack);

    public function createRelatedMenu(RequestStack $requestStack);
}
