<?php

namespace Crmp\AcquisitionBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractCrmpController;
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
class ContractController extends AbstractCrmpController
{
    /**
     * Lists all Contract entities.
     *
     * @Route("/", name="crmp_acquisition_contract_index")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contracts = $em->getRepository('CrmpAcquisitionBundle:Contract')->findAll();

        return $this->render(
            'CrmpAcquisitionBundle:Contract:index.html.twig',
            array(
                'contracts' => $contracts,
            )
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

        if ($request->get('offer')) {
            // customer given: pre-fill form
            $offer = $this->getDoctrine()->getRepository('CrmpAcquisitionBundle:Offer')->find($request->get('offer'));

            $contract->setOffer($offer);
        }

        $form = $this->createForm('Crmp\AcquisitionBundle\Form\ContractType', $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();

            return $this->redirectToRoute('crmp_acquisition_contract_show', array('id' => $contract->getId()));
        }

        return $this->render(
            'CrmpAcquisitionBundle:Contract:new.html.twig',
            array(
                'contract' => $contract,
                'form'     => $form->createView(),
            )
        );
    }

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
