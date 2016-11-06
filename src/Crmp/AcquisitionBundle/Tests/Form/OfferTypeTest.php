<?php


namespace Crmp\AcquisitionBundle\Tests\Form;


use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\OfferType;
use Symfony\Component\Form\Test\TypeTestCase;

class OfferTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title'   => uniqid(),
            'price'   => mt_rand(42, 1337),
            'content' => uniqid(),
            'status'  => 0,
        );

        $form = $this->factory->create(OfferType::class);

        $object = new Offer();
        $object->setTitle($formData['title']);
        $object->setPrice($formData['price']);
        $object->setContent($formData['content']);
        $object->setStatus($formData['status']);

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
