<?php

namespace Crmp\CrmBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Form\CustomerType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Customer controller.
 *
 * @Route("/customer")
 */
class CustomerController extends AbstractCrmpController
{
    /**
     * Deletes a Customer entity.
     *
     * @Route("/{id}", name="crmp_crm_customer_delete")
     * @Method("DELETE")
     *
     * @param Request  $request
     * @param Customer $customer
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Customer $customer)
    {
        $form = $this->createDeleteForm($customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('crmp_crm_customer_index');
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     * @Route("/{id}/edit", name="crmp_crm_customer_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request  $request
     * @param Customer $customer
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);
        $editForm   = $this->createForm('Crmp\CrmBundle\Form\CustomerType', $customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $customerRepository = $this->get('crmp.customer.repository');
            $customerRepository->update($customer);
            $customerRepository->flush();

            return $this->redirectToRoute('crmp_crm_customer_show', array('id' => $customer->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Customer:edit.html.twig',
            array(
                'customer'    => $customer,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Lists all Customer entities.
     *
     * @Route("/", name="crmp_crm_customer_index")
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('CrmpCrmBundle:Customer')->findAll();

        return $this->render(
            'CrmpCrmBundle:Customer:index.html.twig',
            array(
                'customers' => $customers,
            )
        );
    }

    /**
     * Creates a new Customer entity.
     *
     * @Route("/new", name="crmp_crm_customer_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $customer = new Customer();
        $form     = $this->createForm('Crmp\CrmBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('crmp_crm_customer_show', array('id' => $customer->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Customer:new.html.twig',
            array(
                'customer' => $customer,
                'form'     => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/{id}", name="crmp_crm_customer_show")
     * @Method("GET")
     *
     * @param Customer $customer
     *
     * @return Response
     */
    public function showAction(Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);

        return $this->render(
            'CrmpCrmBundle:Customer:show.html.twig',
            array(
                'customer'     => $customer,
                'delete_form'  => $deleteForm->createView(),
                'inquiry_form' => $this->createFormBuilder()->getForm(),
            )
        );
    }

    /**
     * Creates a form to delete a Customer entity.
     *
     * @param Customer $customer The Customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm(Customer $customer)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('crmp_crm_customer_delete', array('id' => $customer->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
