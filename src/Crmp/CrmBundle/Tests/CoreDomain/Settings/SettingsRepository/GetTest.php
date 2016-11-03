<?php


namespace Crmp\CrmBundle\Tests\CoreDomain\Settings\SettingsRepository;


use Crmp\CrmBundle\Entity\User;
use Crmp\CrmBundle\CoreDomain\Settings\SettingsRepository;
use Crmp\CrmBundle\Entity\Setting;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractRepositoryTestCase;

class GetTest extends AbstractRepositoryTestCase
{
    protected $className = SettingsRepository::class;
    protected $repositoryMock;

    public function testFirstItSearchesByUserAndThenTheDefault()
    {
        $name = uniqid();
        $repo = $this->getRepositoryMock();

        $user = new User();
        $user->setUsername(uniqid());

        $defaultSetting = new Setting();
        $defaultSetting->setName($name);

        $returnedSetting = clone $defaultSetting;
        $returnedSetting->setValue(uniqid());

        $userSetting = clone $defaultSetting;
        $userSetting->setUser($user);

        $repo->expects($this->at(0))
             ->method('findSimilar')
             ->with($userSetting);

        $repo->expects($this->at(1))
             ->method('findSimilar')
             ->with($defaultSetting)
             ->willReturn($returnedSetting);

        $this->assertEquals($returnedSetting->getValue(), $repo->get($name, $user));
    }

    public function testItFetchesDataBySearchingSimilar()
    {
        $repo = $this->getRepositoryMock();

        $expectedValue = $value = uniqid();
        $setting       = new Setting();

        $setting->setValue($value);

        $repo->expects($this->once())
             ->method('findSimilar')
             ->willReturn($setting);

        $this->assertEquals($expectedValue, $repo->get(uniqid(), null));
    }

    public function testItReturnsNullWhenNotFound()
    {
        $name = uniqid();

        $repo = $this->getRepositoryMock();

        $this->assertNull($repo->get($name));
    }

    public function testItReusesCachedData()
    {

        $expectedValue = $value = uniqid();
        $name          = uniqid();
        $setting       = new Setting();

        $setting->setName($name)->setValue($value);

        $repo = $this->getRepositoryMock(
            null,
            null,
            [
                'findSimilar' => $setting,
            ]
        );

        $this->assertEquals($expectedValue, $repo->get($name, null));

        $setting->setValue(uniqid());

        // This should stay the same as $setting is an reference to the object
        // which will be returned when calling findSimilar.
        // In terms of reuse and cached data the previous value should still be returned.
        $this->assertEquals($expectedValue, $repo->get($name, null));
    }

}
