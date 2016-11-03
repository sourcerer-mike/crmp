<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\CrmBundle\Panels\Settings\General;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Form\AddressType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Managing addresses.
 *
 * The CRM-Bundle brings you two main entities with customers and addresses.
 *
 * @Route("/address")
 */
class AddressController extends AbstractCrmpController
{
    /**
     * Delete an address.
     *
     * An address shall never be deleted more disabled.
     * Once you delete an address it is completely gone
     * and related invoices, inquiries, offers or other entities will be hard to find.
     * So think twice before deleting/disabling an address.
     *
     * @Route("/{id}", name="crmp_crm_address_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Address $address
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Address $address)
    {
        $form = $this->createDeleteForm($address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush();
        }

        return $this->redirectToRoute('crmp_crm_address_index');
    }

    /**
     * Displays a form to edit an existing Address entity.
     *
     * @Route("/{id}/edit", name="crmp_crm_address_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Address $address
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Address $address)
    {
        $deleteForm = $this->createDeleteForm($address);
        $editForm   = $this->createForm('Crmp\CrmBundle\Form\AddressType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $address->setUpdatedBy($this->getUser());

            $this->get('crmp.address.repository')->update($address);

            return $this->redirectToRoute('crmp_crm_address_show', array('id' => $address->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Address:edit.html.twig',
            array(
                'address'     => $address,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Lists all addresses.
     *
     * To list all addresses go to the address overview.
     * Addresses can be filtered by customer.
     *
     * @Route("/", name="crmp_crm_address_index")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $repo = $this->get('crmp.address.repository');
        $addresses = $repo->findAll($this->getListLimit());

        if ($request->get('customer')) {
            $addresses = $repo->findBy(
                [
                    'customer' => $request->get('customer'),
                ]
            );
        }

        return $this->render(
            'CrmpCrmBundle:Address:index.html.twig',
            array(
                'addresses' => $addresses,
            )
        );
    }

    /**
     * Creates a new Address entity.
     *
     * @Route("/new", name="crmp_crm_address_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $address = new Address();

        if ($request->get('customer')) {
            // customer given: pre-fill form
            $customer = $this->getDoctrine()->getRepository('CrmpCrmBundle:Customer')->find($request->get('customer'));

            $address->setCustomer($customer);
        }

        $form = $this->createForm('Crmp\CrmBundle\Form\AddressType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('crmp_crm_address_show', array('id' => $address->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Address:new.html.twig',
            array(
                'address' => $address,
                'form'    => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Address entity.
     *
     * @Route("/{id}", name="crmp_crm_address_show")
     * @Method("GET")
     *
     * @param Address $address
     *
     * @return Response
     */
    public function showAction(Address $address)
    {
        $deleteForm = $this->createDeleteForm($address);

        return $this->render(
            'CrmpCrmBundle:Address:show.html.twig',
            array(
                'address'     => $address,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Address entity.
     *
     * @param Address $address The Address entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm(Address $address)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('crmp_crm_address_delete', array('id' => $address->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    protected function getListLimit()
    {
        return $this->get('crmp.setting.repository')->get(General::LIST_LIMIT, $this->getUser());
    }
}
