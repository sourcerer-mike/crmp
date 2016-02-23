<?php

namespace Crmp\CrmBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Form\AddressType;

/**
 * Address controller.
 *
 * @Route("/address")
 */
class AddressController extends Controller
{
    /**
     * Lists all Address entities.
     *
     * @Route("/", name="address_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

	    $addressRepository = $em->getRepository( 'CrmBundle:Address' );

	    $addresses = $addressRepository->findAll();

	    if ($request->get('customer')) {
		    $addresses = $addressRepository->findBy(
			    [
			        'customer' => $request->get('customer')
			    ]
		    );
	    }

        return $this->render('CrmBundle:Address:index.html.twig', array(
            'addresses' => $addresses,
        ));
    }

    /**
     * Creates a new Address entity.
     *
     * @Route("/new", name="address_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $address = new Address();

	    if ($request->get('customer')) {
		    // customer given: pre-fill form
		    $customer = $this->getDoctrine()->getRepository('CrmBundle:Customer')->find($request->get('customer'));

		    $address->setCustomer($customer);
	    }

        $form = $this->createForm('Crmp\CrmBundle\Form\AddressType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $this->updateLifecycle( $address );

            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('address_show', array('id' => $address->getId()));
        }

        return $this->render('CrmBundle:Address:new.html.twig', array(
            'address' => $address,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Address entity.
     *
     * @Route("/{id}", name="address_show")
     * @Method("GET")
     */
    public function showAction(Address $address)
    {
        $deleteForm = $this->createDeleteForm($address);

        return $this->render('CrmBundle:Address:show.html.twig', array(
            'address' => $address,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Address entity.
     *
     * @Route("/{id}/edit", name="address_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Address $address)
    {
        $deleteForm = $this->createDeleteForm($address);
        $editForm = $this->createForm('Crmp\CrmBundle\Form\AddressType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
	        $this->updateLifecycle( $address );

            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('address_show', array('id' => $address->getId()));
        }

        return $this->render('CrmBundle:Address:edit.html.twig', array(
            'address' => $address,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Address entity.
     *
     * @Route("/{id}", name="address_delete")
     * @Method("DELETE")
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

        return $this->redirectToRoute('address_index');
    }

    /**
     * Creates a form to delete a Address entity.
     *
     * @param Address $address The Address entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Address $address)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('address_delete', array('id' => $address->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

	/**
	 * @param Address $address
	 */
	private function updateLifecycle( Address $address ) {
		$address->setUpdatedBy( $this->getUser() );

		if ( ! $address->getCreatedBy() ) {
			$address->setCreatedBy( $this->getUser() );
		}
	}
}
