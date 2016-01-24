<?php

namespace Crmp\AcquisitionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Repository\CustomerRepository;

/**
 * Inquiry controller.
 *
 * @Route("/inquiry")
 */
class InquiryController extends Controller
{
    /**
     * Deletes a Inquiry entity.
     *
     * @Route("/{id}", name="inquiry_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Inquiry $inquiry)
    {
        $form = $this->createDeleteForm($inquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inquiry);
            $em->flush();
        }

        return $this->redirectToRoute('inquiry_index');
    }

    /**
     * Displays a form to edit an existing Inquiry entity.
     *
     * @Route("/{id}/edit", name="inquiry_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Inquiry $inquiry)
    {
        $deleteForm = $this->createDeleteForm($inquiry);
        $editForm   = $this->createForm('Crmp\AcquisitionBundle\Form\InquiryType', $inquiry);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiry);
            $em->flush();

            return $this->redirectToRoute('inquiry_edit', array('id' => $inquiry->getId()));
        }

        return $this->render(
            'AcquisitionBundle:Inquiry:edit.html.twig',
            array(
                'inquiry'     => $inquiry,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Lists all Inquiry entities.
     *
     * @Route("/", name="inquiry_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inquiries = $em->getRepository('AcquisitionBundle:Inquiry')->findAll();

        return $this->render(
            'AcquisitionBundle:Inquiry:index.html.twig',
            array(
                'inquiries' => $inquiries,
            )
        );
    }

    /**
     * Creates a new Inquiry entity.
     *
     * @Route("/new", name="inquiry_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $inquiry = new Inquiry();

        if ($request->get('customer')) {
            // customer given: pre-fill form
            $customer = $this->getDoctrine()->getRepository('CrmBundle:Customer')->find($request->get('customer'));

            $inquiry->setCustomer($customer);
        }

        $form = $this->createForm('Crmp\AcquisitionBundle\Form\InquiryType', $inquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiry);
            $em->flush();

            return $this->redirectToRoute('inquiry_show', array('id' => $inquiry->getId()));
        }

        $this->container;

        return $this->render(
            'AcquisitionBundle:Inquiry:new.html.twig',
            array(
                'inquiry' => $inquiry,
                'form'    => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Inquiry entity.
     *
     * @Route("/{id}", name="inquiry_show")
     * @Method("GET")
     */
    public function showAction(Inquiry $inquiry)
    {
        $deleteForm = $this->createDeleteForm($inquiry);

        return $this->render(
            'AcquisitionBundle:Inquiry:show.html.twig',
            array(
                'inquiry'     => $inquiry,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Inquiry entity.
     *
     * @param Inquiry $inquiry The Inquiry entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inquiry $inquiry)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('inquiry_delete', array('id' => $inquiry->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
