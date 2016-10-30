<?php


namespace Crmp\CrmBundle\Tests\CoreDomain;


use Doctrine\Common\Collections\Criteria;

abstract class AbstractRepositoryTestCase extends \PHPUnit_Framework_TestCase
{
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

    abstract protected function getRepositoryMock();
}