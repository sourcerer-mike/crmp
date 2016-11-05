<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\ContractController;


use Crmp\AcquisitionBundle\Controller\ContractController;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Repository\OfferRepository;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractIndexActionTestCase;
use Symfony\Component\HttpFoundation\Request;

class IndexActionTest extends AbstractIndexActionTestCase
{
    protected $controllerClass = ContractController::class;

    public function testItCanFilterByCustomer()
    {
        $relatedEntity = new Customer();
        $relatedEntity->setName(uniqid());

        $contract = new Contract();
        $contract->setCustomer($relatedEntity);

        $this->assertFiltering(
            $relatedEntity,
            CustomerRepository::class,
            'crmp.customer.repository',
            $contract,
            'CrmpAcquisitionBundle:Contract:index.html.twig',
            'contracts',
            'customer'
        );
    }

    public function testItCanFilterByOffer()
    {
        $offer = new Offer();
        $offer->setPrice('0815');

        $contract = new Contract();
        $contract->setOffer($offer);

        $this->assertFiltering(
            $offer,
            OfferRepository::class,
            'crmp.offer.repository',
            $contract,
            'CrmpAcquisitionBundle:Contract:index.html.twig',
            'contracts',
            'offer'
        );
    }

    public function testItShowsAllContracts()
    {
        $expectedSet = [uniqid()];

        $this->expectFindAllSimilar(new Contract())->willReturn($expectedSet);

        $this->expectRenderingWith(
            'CrmpAcquisitionBundle:Contract:index.html.twig',
            [
                'contracts' => $expectedSet,
            ]
        );

        $this->controllerMock->indexAction(new Request([]));
    }
}
