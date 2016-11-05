<?php


namespace Crmp\CrmBundle\Tests\CoreDomain\Settings\SettingsRepository;


use Crmp\CrmBundle\CoreDomain\Settings\SettingsRepository;
use Crmp\CrmBundle\Entity\Setting;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractRepositoryTestCase;

/**
 * FindAllSimilarTest
 *
 * @see SettingsRepository::findAllSimilar()
 *
 * @package Crmp\CrmBundle\Tests\CoreDomain\Settings\SettingsRepository
 */
class FindAllSimilarTest extends AbstractRepositoryTestCase
{
    protected $className = SettingsRepository::class;

    public function testItCanFilterByUser()
    {
        $this->markTestIncomplete();
    }

    public function testItCanFilterByName()
    {
        $this->markTestIncomplete();
    }

    public function testItCanPaginate()
    {
        $this->markTestIncomplete();
    }

    public function testItCanOrderBySomeField()
    {
        $this->markTestIncomplete();
    }

    protected function createEntity()
    {
        return new Setting();
    }

    /**
     * Get the current class name.
     *
     * @return string
     */
    protected function getRepositoryClassName()
    {
        return SettingsRepository::class;
    }
}
