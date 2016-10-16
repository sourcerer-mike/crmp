<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;


use Crmp\AcquisitionBundle\Controller\ContractController;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    protected function setUp()
    {
        $this->controllerClass = ContractController::class;

        parent::setUp();
    }

    public function testContractWillBeDelegatedForRendering()
    {
        $contract = new Contract();
        $contract->setTitle('the title');
        $contract->setContent('the content');

        $this->expectRendering('contract', $contract, 'CrmpAcquisitionBundle:Contract:show.html.twig');

        $this->controllerMock->showAction($contract);
    }
}