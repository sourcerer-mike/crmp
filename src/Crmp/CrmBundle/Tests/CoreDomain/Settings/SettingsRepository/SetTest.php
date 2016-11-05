<?php


namespace Crmp\CrmBundle\Tests\CoreDomain\Settings\SettingsRepository;


use Crmp\CrmBundle\CoreDomain\Settings\SettingsRepository;
use Crmp\CrmBundle\Entity\Setting;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractRepositoryTestCase;
use Doctrine\ORM\EntityManager;

/**
 * Setter for configuration.
 *
 * @see     SettingsRepository::set()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Settings\SettingsRepository
 */
class SetTest extends AbstractRepositoryTestCase
{
    protected $className = SettingsRepository::class;

    public function getSettingData()
    {
        return [
            [uniqid(), uniqid(), null],
        ];
    }

    /**
     * @param $name
     * @param $value
     * @param $user
     *
     * @dataProvider getSettingData
     */
    public function testItForwardsTheSettingToDoctrine($name, $value, $user)
    {
        $expectedName  = $name;
        $expectedValue = $value;
        $expectedUser  = $user;

        $setting = new Setting();
        $setting->setName($name)->setValue($value)->setUser($user);

        $entityManagerMock = $this->createEntityManagerMock();

        $entityManagerMock->expects($this->once())
                          ->method('persist')
                          ->with($setting);

        $repository = $this->createRepositoryMockBuilder(null, $entityManagerMock)->getMock();

        $repository->expects($this->once())
                   ->method('findSimilar')
                   ->willReturn(null);

        $repository->set($name, $value, $user);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createEntityManagerMock()
    {
        return $this->createMock(EntityManager::class);
    }

    protected function createEntity()
    {
        return new Setting();
    }

    /**
     * Get the current class name.
     *
     * With 1.0.0 this method will become so that every test have to implement it.
     *
     * @return string
     */
    protected function getRepositoryClassName()
    {
        return SettingsRepository::class;
    }
}