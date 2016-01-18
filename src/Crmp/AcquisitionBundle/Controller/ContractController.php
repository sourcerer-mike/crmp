<?php

namespace Crmp\AcquisitionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Contract;
use Crmp\AcquisitionBundle\Form\ContractType;

/**
 * Contract controller.
 *
 * @Route("/contract")
 */
class ContractController extends Controller
{
    /**
     * Lists all Contract entities.
     *
     * @Route("/", name="contract_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contracts = $em->getRepository('AcquisitionBundle:Contract')->findAll();

        return $this->render('contract/index.html.twig', array(
            'contracts' => $contracts,
        ));
    }

    /**
     * Creates a new Contract entity.
     *
     * @Route("/new", name="contract_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contract = new Contract();
        $form = $this->createForm('Crmp\AcquisitionBundle\Form\ContractType', $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();

            return $this->redirectToRoute('contract_show', array('id' => $contract->getId()));
        }

        return $this->render('contract/new.html.twig', array(
            'contract' => $contract,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Route("/{id}", name="contract_show")
     * @Method("GET")
     */
    public function showAction(Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);

        return $this->render('contract/show.html.twig', array(
            'contract' => $contract,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contract entity.
     *
     * @Route("/{id}/edit", name="contract_edit")
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

            return $this->redirectToRoute('contract_edit', array('id' => $contract->getId()));
        }

        return $this->render('contract/edit.html.twig', array(
            'contract' => $contract,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contract entity.
     *
     * @Route("/{id}", name="contract_delete")
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

        return $this->redirectToRoute('contract_index');
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
            ->setAction($this->generateUrl('contract_delete', array('id' => $contract->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
