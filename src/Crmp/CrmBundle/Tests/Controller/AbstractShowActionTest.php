<?php

namespace Crmp\CrmBundle\Tests\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

abstract class AbstractShowActionTest extends AbstractControllerTestCase
{
    protected function expectRendering($entityKey, $entity, $template)
    {
        $self               = $this;
        $customerController = $this->controllerMock;

        $customerController->expects($this->once())->method('render')->willReturnCallback(
            function () use ($self, $entity, $template, $entityKey) {
                $args = func_get_args();

                $self->assertEquals($template, $args[0]);
                $self->assertEquals($entity, $args[1][$entityKey]);
            }
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->controllerMock = $this->controllerBuilder->setMethods(
            ['createDeleteForm', 'createFormBuilder', 'render']
        )->getMock();

        $this->controllerMock->expects($this->any())->method('createDeleteForm')->willReturn(
            $this->createMock(Form::class)
        );

        $this->controllerMock->expects($this->any())->method('createFormBuilder')->willReturn(
            $this->createMock(FormBuilder::class)
        );
    }
}