<?php

namespace Crmp\HrBundle\Tests\Controller;

use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('task_index');
    }
}
