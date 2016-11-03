<?php

namespace Crmp\CrmBundle\Tests\CoreDomain;

use Crmp\CoreDomain\RepositoryInterface;
use Doctrine\Common\Collections\Criteria;

abstract class AbstractFindAllSimilarTestCase extends AbstractRepositoryTestCase
{
    public function testItCanOrder()
    {
        $self       = $this;
        $order      = [uniqid() => 'ASC'];
        $entityRepo = $this->getEntitiyRepositoryMock();

        $entityRepo->expects($this->once())
                   ->method('matching')
                   ->willReturnCallback(
                       function (Criteria $criteria) use ($self, $order) {
                           $self->assertEquals($order, $criteria->getOrderings());
                       }
                   );

        $repo = $this->createRepositoryMockBuilder($entityRepo)->getMock();

        /** @var RepositoryInterface $repo */
        $repo->findAllSimilar($this->createEntity(), null, null, $order);
    }

    public function testItCanPaginate()
    {
        $self = $this;

        $amount = mt_rand(42, 1337);
        $start  = mt_rand(42, 1337);

        $entityRepo = $this->getEntitiyRepositoryMock();

        $entityRepo->expects($this->once())
                   ->method('matching')
                   ->willReturnCallback(
                       function (Criteria $criteria) use ($self, $amount, $start) {
                           $self->assertEquals($amount, $criteria->getMaxResults());
                           $self->assertEquals($start, $criteria->getFirstResult());
                       }
                   );

        $repo = $this->createRepositoryMockBuilder($entityRepo)->getMock();

        /** @var RepositoryInterface $repo */
        $repo->findAllSimilar($this->createEntity(), $amount, $start);
    }

    public function testItDelegatesTheSearchToDoctrine()
    {
        $self = $this;

        $entityRepo = $this->getEntitiyRepositoryMock();

        $entityRepo->expects($this->once())
                   ->method('matching')
                   ->willReturnCallback(
                       function (Criteria $criteria) use ($self) {
                           $self->assertNull($criteria->getWhereExpression());
                       }
                   );

        $repo = $this->createRepositoryMockBuilder($entityRepo)->getMock();

        /** @var RepositoryInterface $repo */
        $repo->findAllSimilar($this->createEntity());
    }

    /**
     * Assert which filter must be used.
     *
     * @see RepositoryInterface::findAllSimilar()
     *
     * @param string $fieldName      Name that should be used within the WHERE criteria.
     * @param object $expectedObject Expected entity that will be filtered by.
     * @param object $targetEntity   The entity of the repository.
     */
    protected function assertFilteredBy($fieldName, $expectedObject, $targetEntity)
    {
        // Build expectations.
        $entityRepoMock = $this->getEntitiyRepositoryMock();
        $repo           = $this->getRepositoryMock($entityRepoMock);

        $this->expectCriteria($entityRepoMock, $fieldName, $expectedObject);

        // Check expectations by running filter.
        /** @var InvoiceRepository $repo */
        $repo->findAllSimilar($targetEntity);
    }
}
