<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\AcquisitionBundle\Form\InquiryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Form\CustomerType;

/**
 * Customer controller.
 *
 * @Route("/customer")
 */
class CustomerController extends AbstractLifecycleController
{
    /**
     * Lists all Customer entities.
     *
     * @Route("/", name="customer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('CrmBundle:Customer')->findAll();

        return $this->render('CrmBundle:Customer:index.html.twig', array(
            'customers' => $customers,
        ));
    }

    /**
     * Creates a new Customer entity.
     *
     * @Route("/new", name="customer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm('Crmp\CrmBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $this->updateLifecycle($customer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customer_show', array('id' => $customer->getId()));
        }

        return $this->render('CrmBundle:Customer:new.html.twig', array(
            'customer' => $customer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Customer entity.
     *
     * @Route("/{id}", name="customer_show")
     * @Method("GET")
     */
    public function showAction(Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);

        $inquiryType = new InquiryType();

        return $this->render('CrmBundle:Customer:show.html.twig', array(
            'customer' => $customer,
            'delete_form' => $deleteForm->createView(),
            'inquiry_form' => $this->createFormBuilder()->getForm(),
        ));
    }

    /**
     * Displays a form to edit an existing Customer entity.
     *
     * @Route("/{id}/edit", name="customer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);
        $editForm = $this->createForm('Crmp\CrmBundle\Form\CustomerType', $customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
	        $this->updateLifecycle($customer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('customer_edit', array('id' => $customer->getId()));
        }

        return $this->render('CrmBundle:Customer:edit.html.twig', array(
            'customer' => $customer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Customer entity.
     *
     * @Route("/{id}", name="customer_delete")
     * @Method("DELETE")
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

        return $this->redirectToRoute('customer_index');
    }

    /**
     * Creates a form to delete a Customer entity.
     *
     * @param Customer $customer The Customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Customer $customer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
