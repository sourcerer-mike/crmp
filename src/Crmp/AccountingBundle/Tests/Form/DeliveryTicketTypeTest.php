<?php


namespace Crmp\AccountingBundle\Tests\Form;


use Crmp\AccountingBundle\Entity\DeliveryTicket;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Form\DeliveryTicketType;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Tests\UnitTests\Util;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\TypeTestCase;

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

        $this->builder = $this->factory->createBuilder(DeliveryTicketType::class);
        $this->buildForm();

        $this->mockField(
            'invoice',
            ChoiceType::class,
            ['choices' => ['6' => $invoice], 'choice_label' => null, 'choice_value' => null, 'disabled' => null]
        );

        $this->mockField(
            'contract',
            ChoiceType::class,
            ['choices' => ['5' => $contract], 'choice_label' => null, 'choice_value' => null]
        );

        $form = $this->builder->getForm();

        $object = new DeliveryTicket();
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
     * Invoice automatically filled
     *
     * The invoice field is disabled because the user will come from an invoice context.
     * From there the invoice will be transferred via URL
     * and automatically filled in.
     * This field is just for internal storage
     * and a visual review what the user is about to do.
     *
     */
    public function testTheInvoiceFieldIsDisabled()
    {
        $this->assertTrue($this->builder->get('invoice')->getDisabled());
    }

    protected function buildForm($options = [])
    {
        $type = new DeliveryTicketType();
        $type->buildForm($this->builder, $options);

        $this->mockField('invoice', ChoiceType::class);
        $this->mockField('contract', ChoiceType::class);
    }

    protected function mockField($fieldName, $type, $options = [])
    {
        $unresolved = Util::get($this->builder, 'unresolvedChildren');

        // exchange EntityType with ChoiceType
        $invoiceOptions = $unresolved[$fieldName]['options'];

        unset($invoiceOptions['class']);

        $invoiceOptions = array_filter(array_merge($invoiceOptions, $options));

        $this->builder->add($fieldName, $type, $invoiceOptions);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->buildForm();
    }


}
