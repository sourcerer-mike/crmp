<?php

namespace Crmp\CrmBundle\Tests\Panels\Settings\General;

use Crmp\CrmBundle\Panels\Settings\General;
use Crmp\CrmBundle\Tests\UnitTests\Util;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormBuilderInterface;

class CreateFormBuilderTest extends KernelTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::bootKernel();
    }

    public static function tearDownAfterClass()
    {
        static::ensureKernelShutdown();
    }

    public function testItHasFieldsForGeneralSettings()
    {
        $form = $this->createFormBuilder();

        $this->assertNotNull($generalLimitList = $form->get(General::LIST_LIMIT));
    }

    public function testListLimitCanNotBeLowerThanZero()
    {
        $form = $this->createFormBuilder();

        $form->getForm()->submit([General::LIST_LIMIT => -1]);

        $this->assertFalse($form->getForm()->get(General::LIST_LIMIT)->isValid());
    }

    /**
     * @return FormBuilderInterface
     */
    protected function createFormBuilder()
    {
        $general = new General();
        $general->setContainer(static::$kernel->getContainer());

        return Util::call($general, 'createFormBuilder');
    }

    /**
     * Disabled tear down of kernel after each test.
     */
    protected function tearDown()
    {
    }


}