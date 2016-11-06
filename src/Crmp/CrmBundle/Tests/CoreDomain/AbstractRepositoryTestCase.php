<?php


namespace Crmp\CrmBundle\Tests\CoreDomain;


use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\CoreDomain\Settings\SettingsRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepositoryTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     *
     * @deprecated 1.0.0 Use the method ::getRepositoryClassName() instead.
     */
    protected $className;
    protected $repositoryMock;

    abstract protected function createEntity();

    protected function createEntityManagerMock()
    {
        return $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @param $repo
     * @param $entityManager
     *
     * @return SettingsRepository|\PHPUnit_Framework_MockObject_MockBuilder
     */
    protected function createRepositoryMockBuilder($repo = null, $entityManager = null)
    {
        $settingsRepository = $this->getMockBuilder($this->getRepositoryClassName());

        if (! $repo) {
            $repo = $this->createMock(EntityRepository::class);
        }

        if (! $entityManager) {
            $entityManager = $this->createEntityManagerMock();
        }

        $settingsRepository->setConstructorArgs([$repo, $entityManager])
                           ->setMethods(
                               [
                                   'findSimilar',
                               ]
                           );

        return $settingsRepository;
    }

    /**
     * Check for criteria.
     *
     * @param        $repositoryMock
     * @param string $fieldName
     * @param object $expectedObject
     */
    protected function expectCriteria($repositoryMock, $fieldName, $expectedObject)
    {
        $self = $this;
        $repositoryMock->expects($this->once())
                       ->method('matching')
                       ->willReturnCallback(
                           function (Criteria $criteria) use ($self, $fieldName, $expectedObject) {
                               /** @var \Doctrine\Common\Collections\Expr\Comparison $expression */
                               $expression = $criteria->getWhereExpression();

                               $self->assertEquals($fieldName, $expression->getField());
                               $self->assertEquals($expectedObject, $expression->getValue()->getValue());
                           }
                       );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEntitiyRepositoryMock()
    {
        return $this->getMockBuilder(EntityRepository::class)
                    ->disableOriginalConstructor()
                    ->setMethods(['matching'])
                    ->getMock();
    }

    /**
     * Get the current class name.
     *
     * @return string
     */
    abstract protected function getRepositoryClassName();

    protected function getRepositoryMock($repo = null, $entityManager = null, $methodReturnMap = [])
    {
        if ($this->repositoryMock) {
            return $this->repositoryMock;
        }

        $settingsRepository = $this->createRepositoryMockBuilder($repo, $entityManager);

        if ($methodReturnMap) {
            $settingsRepository->setMethods(array_keys($methodReturnMap));
        }

        $mock = $settingsRepository->getMock();
        foreach ($methodReturnMap as $method => $return) {
            $mock->expects($this->atLeastOnce())
                 ->method($method)
                 ->willReturn($return);
        }

        return $mock;
    }
}
