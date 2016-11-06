<?php

namespace Crmp\AcquisitionBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractRepositoryController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Form\ContractType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contract controller.
 *
 * @Route("/contract")
 */
class ContractController extends AbstractRepositoryController
{
    const ENTITY_NAME  = 'contract';
    const FORM_TYPE    = ContractType::class;
    const ROUTE_DELETE = 'crmp_acquisition_contract_delete';
    const ROUTE_INDEX  = 'crmp_acquisition_contract_index';
    const ROUTE_SHOW   = 'crmp_acquisition_contract_show';
    const VIEW_EDIT    = 'CrmpAcquisitionBundle:Contract:edit.html.twig';
    const VIEW_SHOW    = 'CrmpAcquisitionBundle:Contract:show.html.twig';

    /**
     * Lists all Contract entities.
     *
     * @Route("/", name="crmp_acquisition_contract_index")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $contract = new Contract();

        if ($request->get('customer')) {
            $contract->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        if ($request->get('offer')) {
            $contract->setOffer(
                $this->get('crmp.offer.repository')->find($request->get('offer'))
            );
        }

        return $this->render(
            'CrmpAcquisitionBundle:Contract:index.html.twig',
            [
                'contracts' => $this->findAllSimilar($contract),
            ]
        );
    }

    /**
     * Creates a new Contract entity.
     *
     * @param Request $request
     *
     * @Route("/new", name="crmp_acquisition_contract_new")
     * @Method({"GET", "POST"})
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $contract = new Contract();

        if ($request->get('customer')) {
            $contract->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        if ($request->get('offer')) {
            // customer given: pre-fill form
            $contract->setOffer(
                $this->get('crmp.offer.repository')->find($request->get('offer'))
            );
        }

        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getMainRepository()->persist($contract);

            return $this->redirectToRoute('crmp_acquisition_contract_show', array('id' => $contract->getId()));
        }

        return $this->render(
            'CrmpAcquisitionBundle:Contract:new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        return $this->get('crmp.contract.repository');
    }
}
