<?php

namespace Crmp\Tests\CoreDomain\Settings;

use Crmp\CoreDomain\Settings\Setting;
use Crmp\CrmBundle\Entity\User;

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

    public function testItHasAValue()
    {
        $setting = new Setting();

        // copy value to suppress changes by reference
        $expectedValue = $value = uniqid();

        $setting->setUser($value);

        $this->assertEquals($expectedValue, $setting->getUser());
    }

    public function testSettingsCanBeBoundToAnUser()
    {
        $setting = new Setting();

        // copy value to suppress changes by reference
        $user = new User();
        $user->setUsername(uniqid());

        $setting->setUser($user);

        $this->assertEquals($user, $setting->getUser());
    }
}
