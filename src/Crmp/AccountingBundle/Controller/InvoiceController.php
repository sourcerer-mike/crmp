<?php

namespace Crmp\AccountingBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractCrmpController;
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
    const ROUTE_DELETE = 'crmp_accounting_invoice_delete';
    const ROUTE_INDEX  = 'crmp_accounting_invoice_index';
    const ROUTE_SHOW   = 'crmp_accounting_invoice_show';

    /**
     * Change a single existing invoice.
     *
     * Sometimes a customer should pay more or less for a service
     * or the invoice needs more details than the contract offered.
     * In such cases you can edit the invoice.
     *
     * @param Request $request
     * @param Invoice $invoice
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Invoice $invoice)
    {
        $editForm = $this->createForm(InvoiceType::class, $invoice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getMainRepository()->persist($invoice);

            return $this->redirectToRoute(self::ROUTE_SHOW, array('id' => $invoice->getId()));
        }

        return $this->render(
            'CrmpAccountingBundle:Invoice:edit.html.twig',
            array(
                'invoice'     => $invoice,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $this->createDeleteForm($invoice)->createView(),
            )
        );
    }

    /**
     * Lists all invoices.
     *
     * Control all invoices.
     * You can apply some filters here to get a better overview.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $searchInvoice = new Invoice();

        if ($request->get('customer')) {
            $searchInvoice->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        return $this->render(
            'CrmpAccountingBundle:Invoice:index.html.twig',
            array(
                'invoices' => $this->fetchSimilar($searchInvoice, $request),
            )
        );
    }

    /**
     * Creating a new invoice.
     *
     * Invoices keep your business going especially the paid ones.
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
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        if ($request->get('value')) {
            $invoice->setValue((float) $request->get('value'));
        }

        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getMainRepository()->persist($invoice);

            return $this->redirectToRoute(self::ROUTE_SHOW, array('id' => $invoice->getId()));
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
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        return $this->get('crmp.invoice.repository');
    }
}
