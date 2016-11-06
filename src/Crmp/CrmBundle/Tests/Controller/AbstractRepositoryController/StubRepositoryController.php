<?php


namespace Crmp\CrmBundle\Tests\Controller\AbstractRepositoryController;


use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractRepositoryController;

class StubRepositoryController extends AbstractRepositoryController
{
    const ENTITY_NAME  = 'stub';
    const FORM_TYPE    = StubType::class;
    const ROUTE_DELETE = 'none';
    const ROUTE_INDEX  = 'none';
    const ROUTE_SHOW   = 'none';
    const VIEW_EDIT    = 'none';
    const VIEW_SHOW    = 'none';

    /**
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        return null;
    }
}
