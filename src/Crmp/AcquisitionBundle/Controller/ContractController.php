<?php

namespace Crmp\AcquisitionBundle\Controller;

use AppBundle\Controller\CrmpController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Form\ContractType;

/**
 * Contract controller.
 *
 * @Route("/contract")
 */
class ContractController extends CrmpController
{
    /**
     * Lists all Contract entities.
     *
     * @Route("/", name="crmp_acquisition_contract_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contracts = $em->getRepository('CrmpAcquisitionBundle:Contract')->findAll();

        return $this->render('CrmpAcquisitionBundle:Contract:index.html.twig', array(
            'contracts' => $contracts,
        ));
    }

    /**
     * Creates a new Contract entity.
     *
     * @Route("/new", name="crmp_acquisition_contract_new")
     * @Method({"GET", "POST"})
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

        return $this->render('CrmpAcquisitionBundle:Contract:new.html.twig', array(
            'contract' => $contract,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Route("/{id}", name="crmp_acquisition_contract_show")
     * @Method("GET")
     */
    public function showAction(Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);

        return $this->render('CrmpAcquisitionBundle:Contract:show.html.twig', array(
            'contract' => $contract,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contract entity.
     *
     * @Route("/{id}/edit", name="crmp_acquisition_contract_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);
        $editForm = $this->createForm('Crmp\AcquisitionBundle\Form\ContractType', $contract);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();

            return $this->redirectToRoute('crmp_acquisition_contract_edit', array('id' => $contract->getId()));
        }

        return $this->render('CrmpAcquisitionBundle:Contract:edit.html.twig', array(
            'contract' => $contract,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contract entity.
     *
     * @Route("/{id}", name="crmp_acquisition_contract_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contract $contract)
    {
        $form = $this->createDeleteForm($contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contract);
            $em->flush();
        }

        return $this->redirectToRoute('crmp_acquisition_contract_index');
    }

    /**
     * Creates a form to delete a Contract entity.
     *
     * @param Contract $contract The Contract entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contract $contract)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crmp_acquisition_contract_delete', array('id' => $contract->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
