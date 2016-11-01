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

    /**
     * Get current mock for the repository.
     *
     * @deprecated 1.0.0 This needs to be a ::createRepositoryMockBuilder used by ::getRepositoryMock.
     *
     * @param null $repo
     * @param null $entityManager
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRepositoryMock($repo = null, $entityManager = null)
    {

        $settingsRepository = $this->createRepositoryMockBuilder($repo, $entityManager);

        return $settingsRepository->getMock();
    }
}