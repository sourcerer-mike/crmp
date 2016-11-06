<?php


namespace Crmp\AcquisitionBundle\Tests\Form;


use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\ContractType;
use Crmp\AcquisitionBundle\Form\OfferType;
use Symfony\Component\Form\Test\TypeTestCase;

class ContractTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title'   => uniqid(),
            'content' => uniqid(),
            'value'   => mt_rand(42, 1337),
        );

        $form = $this->factory->create(ContractType::class);

        $object = new Contract();
        $object->setTitle($formData['title']);
        $object->setContent($formData['content']);
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
}
