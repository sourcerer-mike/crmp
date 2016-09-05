<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\OfferController;


use Crmp\AcquisitionBundle\Controller\OfferController;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Form;

/**
 * Show offer
 *
 * It is possible to view a single offer.
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\OfferController
 */
class ShowActionTest extends KernelTestCase
{
    /**
     * Assert that the render method will be called.
     *
     * - Should use the 'CrmpAcquisitionBundle:Offer:show.html.twig'
     * - Should have the offer
     * - Should have a delete form
     */
    public function testItRendersAnOffer()
    {
        // Preconditions
        $stub = new Offer();
        $stub
            ->setTitle(uniqid())
            ->setContent(uniqid())
            ->setPrice(1234)
            ->setStatus(0);

        $controller = $this->getMockBuilder(OfferController::class)->setMethods(['render', 'createDeleteForm'])
                           ->getMock();


        $deleteForm = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $deleteForm->method('createView')->willReturn(uniqid());
        $controller->method('createDeleteForm')->willReturn($deleteForm);

        // Assertions
        $controller->expects($this->once())->method('render')->will(
            $this->returnCallback(
                function ($template, $data) use ($stub, $deleteForm) {
                    \PHPUnit_Framework_Assert::assertEquals('CrmpAcquisitionBundle:Offer:show.html.twig', $template);
                    \PHPUnit_Framework_Assert::assertEquals($stub, $data['offer']);
                    \PHPUnit_Framework_Assert::assertEquals($deleteForm->createView(), $data['delete_form']);
                }
            )
        );

        /** @var OfferController $controller */
        $controller->setContainer(static::$kernel->getContainer());
        $controller->showAction($stub);
    }

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();
    }
}