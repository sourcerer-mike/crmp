<?php

namespace Crmp\Tests\CoreDomain\Settings;

use Crmp\CoreDomain\Settings\Setting;

/**
 * Testing the settings class.
 *
 * @see     Setting
 *
 * @package Crmp\Tests\CoreDomain\Settings
 */
class SettingTest extends \PHPUnit_Framework_TestCase
{
    public function testANameForTheSettingCanBeSet()
    {
        $setting = new Setting();

        // copy value to suppress changes by reference
        $expectedName = $name = uniqid();

        $setting->setName($name);

        $this->assertEquals($expectedName, $setting->getName());
    }

    public function testItCanBeAppliedToASingleUser()
    {
        $setting = new Setting();

        // copy value to suppress changes by reference
        $expectedValue = $value = mt_rand(42, 1337);

        $setting->setValue($value);

        $this->assertEquals($expectedValue, $setting->getValue());
    }

    public function testItCanBeIdentifiedById()
    {
        // copy value to suppress changes by reference
        $expectedValue = $value = mt_rand(42, 1337);
        $setting       = new Setting($value);

        $this->assertEquals($expectedValue, $setting->getId());
    }

    public function testItHasAnValue()
    {
        $setting = new Setting();

        // copy value to suppress changes by reference
        $expectedValue = $value = uniqid();

        $setting->setUser($value);

        $this->assertEquals($expectedValue, $setting->getUser());
    }
}
