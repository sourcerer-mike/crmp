<?php


namespace Crmp\AccountingBundle\Tests\Form;


use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Form\InvoiceType;
use Crmp\CrmBundle\Entity\Customer;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class InvoiceTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $customer = new Customer();
        $customer->setName(uniqid());

        $formData = array(
            'customer' => $customer,
            'value'    => mt_rand(42, 1337),
        );

        $form = $this->factory->create(InvoiceType::class);

        $object = new Invoice();
        $object->setCustomer($formData['customer']);
        $object->setValue($formData['value']);

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

    /**
     * Load the ValidatorExtension so RepeatedType can resolve 'invalid_message'
     *
     * @return array
     */
    protected function getExtensions()
    {
        return [new ValidatorExtension(Validation::createValidator())];
    }

}
