<?php

namespace Crmp\AcquisitionBundle\Controller;

use AppBundle\Controller\AbstractCrmpController;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Symfony\Component\HttpFoundation\Response;

/**
 * Inquiry controller.
 *
 * @Route("/inquiry")
 */
class InquiryController extends AbstractCrmpController
{
    /**
     * Deletes a Inquiry entity.
     *
     * @Route("/{id}", name="crmp_acquisition_inquiry_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Inquiry $inquiry
     *
     * @return RedirectResponse
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

        return $this->redirectToRoute('crmp_acquisition_inquiry_index');
    }

    /**
     * Displays a form to edit an existing Inquiry entity.
     *
     * @param Request $request
     * @param Inquiry $inquiry
     *
     * @Route("/{id}/edit", name="crmp_acquisition_inquiry_edit")
     * @Method({"GET", "POST"})
     *
     * @return RedirectResponse|Response
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

            return $this->redirectToRoute('crmp_acquisition_inquiry_edit', array('id' => $inquiry->getId()));
        }

        return $this->render(
            'CrmpAcquisitionBundle:Inquiry:edit.html.twig',
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
     * @param Request $request
     *
     * @Route("/", name="crmp_acquisition_inquiry_index")
     * @Method("GET")
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

        $inquiries = $em->getRepository('CrmpAcquisitionBundle:Inquiry')->matching($criteria);

        return $this->render(
            'CrmpAcquisitionBundle:Inquiry:index.html.twig',
            array(
                'inquiries' => $inquiries,
            )
        );
    }

    /**
     * Creates a new Inquiry entity.
     *
     * @param Request $request
     *
     * @Route("/new", name="crmp_acquisition_inquiry_new")
     * @Method({"GET", "POST"})
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $inquiry = new Inquiry();

        if ($request->get('customer')) {
            // customer given: pre-fill form
            $customer = $this->getDoctrine()->getRepository('CrmpCrmBundle:Customer')->find($request->get('customer'));

            $inquiry->setCustomer($customer);
        }

        $inquiry->setInquiredAt(new \DateTime());

        $form = $this->createForm('Crmp\AcquisitionBundle\Form\InquiryType', $inquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inquiry);
            $em->flush();

            return $this->redirectToRoute('crmp_acquisition_inquiry_show', array('id' => $inquiry->getId()));
        }

        $this->container;

        return $this->render(
            'CrmpAcquisitionBundle:Inquiry:new.html.twig',
            array(
                'inquiry' => $inquiry,
                'form'    => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Inquiry entity.
     *
     * @param Inquiry $inquiry
     *
     * @Route("/{id}", name="crmp_acquisition_inquiry_show")
     * @Method("GET")
     *
     * @return Response
     */
    public function showAction(Inquiry $inquiry)
    {
        $deleteForm = $this->createDeleteForm($inquiry);

        return $this->render(
            'CrmpAcquisitionBundle:Inquiry:show.html.twig',
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
    protected function createDeleteForm(Inquiry $inquiry)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('crmp_acquisition_inquiry_delete', array('id' => $inquiry->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
