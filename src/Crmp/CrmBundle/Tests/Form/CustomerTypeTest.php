<?php

namespace Crmp\CrmBundle\Tests\Form;

use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Form\CustomerType;
use Symfony\Component\Form\Test\TypeTestCase;


class CustomerTypeTest extends TypeTestCase
{
    protected $validator;

    public function testSubmitValidData()
    {
        $formData = array(
            'name' => uniqid(),
        );

        // configureOptions

        $form = $this->factory->create(CustomerType::class);

        $object = new Customer();
        $object->setName($formData['name']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view     = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
