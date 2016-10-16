<?php

namespace Crmp\CrmBundle\Tests\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

abstract class AbstractShowActionTest extends AbstractControllerTestCase
{
    protected function createFormBuilderMock()
    {
        $this->controllerMock->expects($this->any())->method('createFormBuilder')->willReturn(
            $formBuilder = $this->createMock(FormBuilder::class)
        );

        return $formBuilder;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->controllerMock = $this->controllerBuilder->setMethods(
            ['createDeleteForm', 'createFormBuilder', 'render']
        )->getMock();

        $this->createDeleteFormMock();
        $this->createFormBuilderMock();
    }
}