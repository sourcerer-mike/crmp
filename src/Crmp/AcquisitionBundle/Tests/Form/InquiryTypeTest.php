<?php


namespace Crmp\AcquisitionBundle\Tests\Form;


use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Form\InquiryType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InquiryTypeTest extends TypeTestCase
{
    protected $validator;

    public function testSubmitValidData()
    {
        $dateTime = new \DateTime();
        $formData = array(
            'title'      => uniqid(),
            'netValue'   => mt_rand(42, 1337) * 10,
            'status'     => 1,
            'content'    => uniqid(),
            'inquiredAt' => $dateTime->format('d.m.yy'),
        );

        $form = $this->factory->create(InquiryType::class);

        $object = new Inquiry();
        $object->setTitle($formData['title']);
        $object->setNetValue($formData['netValue']);
        $object->setStatus($formData['status']);
        $object->setContent($formData['content']);
        $object->setInquiredAt($formData['inquiredAt']);

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
