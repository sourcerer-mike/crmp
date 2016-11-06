<?php

namespace Crmp\AccountingBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractRepositoryController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Crmp\AccountingBundle\Entity\Invoice;
use Crmp\AccountingBundle\Form\InvoiceType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Invoices
 *
 * Manage invoices in the "/invoice" section.
 * Invoices keep your business going.
 *
 */
class InvoiceController extends AbstractRepositoryController
{
    const ENTITY_NAME  = 'invoice';
    const FORM_TYPE    = InvoiceType::class;
    const ROUTE_DELETE = 'crmp_accounting_invoice_delete';
    const ROUTE_INDEX  = 'crmp_accounting_invoice_index';
    const ROUTE_SHOW   = 'crmp_accounting_invoice_show';
    const VIEW_EDIT    = 'CrmpAccountingBundle:Invoice:edit.html.twig';
    const VIEW_SHOW    = 'CrmpAccountingBundle:Invoice:show.html.twig';

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
                'invoices' => $this->findAllSimilar($searchInvoice, $request),
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
                self::ENTITY_NAME => $invoice,
                'form'            => $form->createView(),
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
