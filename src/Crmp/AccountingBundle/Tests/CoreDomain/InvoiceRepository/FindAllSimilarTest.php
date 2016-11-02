<?php

namespace Crmp\AccountingBundle\Tests\CoreDomain\InvoiceRepository;

use Crmp\AccountingBundle\CoreDomain\InvoiceRepository;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\CrmBundle\Tests\CoreDomain\AbstractFindAllSimilarTestCase;

/**
 * Class FindAllSimilarTest
 *
 * @see     InvoiceRepository::findAllSimilar()
 *
 * @package Crmp\AccountingBundle\Tests\CoreDomain\InvoiceRepository
 */
class FindAllSimilarTest extends AbstractFindAllSimilarTestCase
{
    protected function createEntity()
    {
        return Invoice::class;
    }

    protected function getRepositoryClassName()
    {
        return InvoiceRepository::class;
    }
}
