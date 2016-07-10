<?php

namespace Crmp\AcquisitionBundle\Controller;

use AppBundle\Controller\CrmpController;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\OfferType;

/**
 * Offer controller.
 *
 * Create, print or send an offer to your customers.
 *
 * @Route("/offer")
 */
class OfferController extends CrmpController
{
    /**
     * Deletes an offer.
     *
     * Please refrain from deleting entities.
     *
     * @param Request $request
     * @param Offer   $offer
     *
     * @Route("/{id}", name="crmp_acquisition_offer_delete")
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Offer $offer)
    {
        $form = $this->createDeleteForm($offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offer);
            $em->flush();
        }

        return $this->redirectToRoute('crmp_acquisition_offer_index');
    }

    /**
     * Edit an existing offer.
     *
     * Change the contents or value of an offer.
     *
     * @param Request $request
     * @param Offer   $offer
     *
     * @Route("/{id}/edit", name="crmp_acquisition_offer_edit")
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Offer $offer)
    {
        $deleteForm = $this->createDeleteForm($offer);
        $editForm   = $this->createForm('Crmp\AcquisitionBundle\Form\OfferType', $offer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('crmp_acquisition_offer_edit', array('id' => $offer->getId()));
        }

        return $this->render(
            'CrmpAcquisitionBundle:Offer:edit.html.twig',
            array(
                'offer'       => $offer,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Lists all offers.
     *
     * Have a look at all offers and filter them as you like.
     *
     * @param Request $request
     *
     * @Route("/", name="crmp_acquisition_offer_index")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $criteria = Criteria::create();

        if ($request->get('inquiry')) {
            $inquiry = $this->getDoctrine()
                            ->getRepository('CrmpAcquisitionBundle:Inquiry')
                            ->find($request->get('inquiry'));

            $criteria->andWhere($criteria->expr()->eq('inquiry', $inquiry));
        }

        if ($request->get('customer')) {
            $customer = $this->getDoctrine()
                             ->getRepository('CrmpCrmBundle:Customer')
                             ->find($request->get('customer'));

            $criteria->andWhere($criteria->expr()->eq('customer', $customer));
        }

        $offers = $em->getRepository('CrmpAcquisitionBundle:Offer')->matching($criteria);

        return $this->render(
            'CrmpAcquisitionBundle:Offer:index.html.twig',
            array(
                'offers' => $offers,
            )
        );
    }

    /**
     * Create a new offer.
     *
     * Create a new offer and stick it to some customer.
     *
     * @param Request $request
     *
     * @Route("/new", name="crmp_acquisition_offer_new")
     * @Method({"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $offer = new Offer();

        if ($request->get('inquiry')) {
            // customer given: pre-fill form
            $inquiry = $this->getDoctrine()->getRepository('CrmpAcquisitionBundle:Inquiry')->find(
                $request->get('inquiry')
            );

            $offer->setInquiry($inquiry);
        }

        if ($request->get('customer')) {
            // customer given: pre-fill form
            $customer = $this->getDoctrine()->getRepository('CrmpCrmBundle:Customer')->find($request->get('customer'));

            $offer->setCustomer($customer);
        }

        $offer->setStatus(0);

        $form = $this->createForm('Crmp\AcquisitionBundle\Form\OfferType', $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('crmp_acquisition_offer_show', array('id' => $offer->getId()));
        }

        return $this->render(
            'CrmpAcquisitionBundle:Offer:new.html.twig',
            array(
                'offer' => $offer,
                'form'  => $form->createView(),
            )
        );
    }

    /**
     * Find and display an offer.
     *
     * Look up a single offer.
     * You can read what the customer will become when he sets the contract.
     *
     * @param Offer $offer
     *
     * @Route("/{id}", name="crmp_acquisition_offer_show")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Offer $offer)
    {
        $deleteForm = $this->createDeleteForm($offer);

        return $this->render(
            'CrmpAcquisitionBundle:Offer:show.html.twig',
            array(
                'offer'       => $offer,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Offer entity.
     *
     * @param Offer $offer The Offer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offer $offer)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('crmp_acquisition_offer_delete', array('id' => $offer->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }
}
