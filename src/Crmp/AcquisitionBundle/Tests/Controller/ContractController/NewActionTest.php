<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;

use Crmp\AcquisitionBundle\Controller\ContractController;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\ContractType;
use Crmp\AcquisitionBundle\Repository\OfferRepository;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class NewActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = ContractController::class;

    public function testItAllowsSettingTheCustomerViaRequest()
    {
        $contract   = new Contract();
        $customerId = mt_rand(42, 1337);

        $customer = new Customer();
        $customer->setName(uniqid());

        $contract->setCustomer($customer);

        $customerRepository = $this->mockRepositoryService('crmp.customer.repository', CustomerRepository::class);

        $customerRepository->expects($this->once())
                           ->method('find')
                           ->with($customerId)
                           ->willReturn($customer);

        $this->expectForm(ContractType::class, $contract);

        $this->controllerMock->newAction(new Request(['customer' => $customerId]));
    }


    public function testItAllowsSettingTheOfferViaRequest()
    {
        $contract   = new Contract();
        $offerId = mt_rand(42, 1337);

        $offer = new Offer();
        $offer->setTitle(uniqid());

        $contract->setOffer($offer);

        $repositoryService = $this->mockRepositoryService('crmp.offer.repository', OfferRepository::class);

        $repositoryService->expects($this->once())
                          ->method('find')
                          ->with($offerId)
                          ->willReturn($offer);

        $this->expectForm(ContractType::class, $contract);

        $this->controllerMock->newAction(new Request(['offer' => $offerId]));
    }

    public function testItCreatesTheContractForm()
    {
        $contract = new Contract();

        $formMock = $this->expectForm(ContractType::class, $contract);

        $expectedView = uniqid();
        $formMock->expects($this->once())
                 ->method('createView')
                 ->willReturn($expectedView);

        $this->expectRenderingWith(
            'CrmpAcquisitionBundle:Contract:new.html.twig',
            [
                'form' => $expectedView,
            ]
        );

        $this->controllerMock->newAction(new Request());
    }
}