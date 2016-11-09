<?php


namespace Crmp\AccountingBundle\Tests\Form;


use Crmp\AccountingBundle\Entity\DeliveryTicket;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Form\DeliveryTicketType;
use Crmp\AccountingBundle\Form\InvoiceType;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Entity\Customer;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class DeliveryTicketTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $contract = new Contract();
        $contract->setValue(mt_rand(42, 1337));

        $invoice = new Invoice();
        $invoice->setValue(mt_rand(42, 1337));

        $formData = array(
            'contract' => $contract,
            'invoice'  => $invoice,
            'title'    => uniqid(),
            'value'    => (float) mt_rand(42, 1337),
        );

        $form = $this->factory->create(DeliveryTicketType::class);

        $object = new DeliveryTicket();
        $object->setContract($formData['contract']);
        $object->setInvoice($formData['invoice']);
        $object->setTitle($formData['title']);
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
