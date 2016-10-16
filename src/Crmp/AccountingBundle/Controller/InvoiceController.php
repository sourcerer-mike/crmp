<?php

namespace Crmp\AccountingBundle\Controller;

use AppBundle\Controller\AbstractCrmpController;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Form\InvoiceType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Invoices
 *
 * Manage invoices in the "/invoice" section.
 * Invoices keep your business going.
 *
 * @Route("/invoice")
 */
class InvoiceController extends AbstractCrmpController
{
    /**
     * Deletes an invoice.
     *
     * You should not delete invoices as this is needed for accounting.
     * Anyways CRMP allows you to delete entities as if they never existed.
     * Please be careful deleting things.
     *
     * @Route("/{id}", name="crmp_accounting_invoice_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Invoice $invoice
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Invoice $invoice)
    {
        $form = $this->createDeleteForm($invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($invoice);
            $em->flush();
        }

        return $this->redirectToRoute('crmp_accounting_invoice_index');
    }

    /**
     * Change a single existing invoice.
     *
     * Sometimes a customer should pay more or less for a service
     * or the invoice needs more details than the contract offered.
     * In such cases you can edit the invoice.
     *
     * @Route("/{id}/edit", name="crmp_accounting_invoice_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Invoice $invoice
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Invoice $invoice)
    {
        $deleteForm = $this->createDeleteForm($invoice);
        $editForm   = $this->createForm('Crmp\AccountingBundle\Form\InvoiceType', $invoice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('crmp_accounting_invoice_edit', array('id' => $invoice->getId()));
        }

        return $this->render(
            'CrmpAccountingBundle:Invoice:edit.html.twig',
            array(
                'invoice'     => $invoice,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Lists all invoices.
     *
     * Control all invoices.
     * You can apply some filters here to get a better overview.
     *
     * @Route("/", name="crmp_accounting_invoice_index")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = Criteria::create();

        if ($request->get('customer')) {
            $customer = $this->getDoctrine()->getRepository('CrmpCrmBundle:Customer')->find($request->get('customer'));
            $criteria->andWhere(Criteria::expr()->eq('customer', $customer));
        }

        $invoices = $em->getRepository('CrmpAccountingBundle:Invoice')->matching($criteria);

        return $this->render(
            'CrmpAccountingBundle:Invoice:index.html.twig',
            array(
                'invoices' => $invoices,
            )
        );
    }

    /**
     * Creating a new invoice.
     *
     * Invoices keep your business going especially the paid ones.
     *
     * @Route("/new", name="crmp_accounting_invoice_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $invoice = new Invoice();

        if ($request->get('customer')) {
            $invoice->setCustomer(
                $this->getDoctrine()->getRepository('CrmpCrmBundle:Customer')->find($request->get('customer'))
            );
        }

        if ($request->get('value')) {
            $invoice->setValue((float) $request->get('value'));
        }

        $form = $this->createForm('Crmp\AccountingBundle\Form\InvoiceType', $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('crmp_accounting_invoice_show', array('id' => $invoice->getId()));
        }

        return $this->render(
            'CrmpAccountingBundle:Invoice:new.html.twig',
            array(
                'invoice' => $invoice,
                'form'    => $form->createView(),
            )
        );
    }

    /**
     * Look at a single invoice.
     *
     * Recheck a single invoice calling "/invoice/{id}".
     *
     * @Route("/{id}", name="crmp_accounting_invoice_show")
     * @Method("GET")
     *
     * @param Invoice $invoice
     *
     * @return Response
     */
    public function showAction(Invoice $invoice)
    {
        $deleteForm = $this->createDeleteForm($invoice);

        return $this->render(
            'CrmpAccountingBundle:Invoice:show.html.twig',
            array(
                'invoice'     => $invoice,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Invoice entity.
     *
     * @param Invoice $invoice The Invoice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm(Invoice $invoice)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('crmp_accounting_invoice_delete', array('id' => $invoice->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
