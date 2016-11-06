<?php

namespace Crmp\AcquisitionBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractRepositoryController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\AcquisitionBundle\Entity\Offer;
use Crmp\AcquisitionBundle\Form\OfferType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Offer controller.
 *
 * Create, print or send an offer to your customers.
 *
 * @Route("/offer")
 */
class OfferController extends AbstractRepositoryController
{
    const ENTITY_NAME  = 'offer';
    const FORM_TYPE    = OfferType::class;
    const ROUTE_DELETE = 'crmp_acquisition_offer_delete';
    const ROUTE_INDEX  = 'crmp_acquisition_offer_index';
    const ROUTE_SHOW   = 'crmp_acquisition_offer_show';
    const VIEW_EDIT    = 'CrmpAcquisitionBundle:Offer:edit.html.twig';
    const VIEW_SHOW    = 'CrmpAcquisitionBundle:Offer:show.html.twig';

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
        $offerTemplate = new Offer();

        if ($request->get('inquiry')) {
            $offerTemplate->setInquiry(
                $this->get('crmp.inquiry.repository')->find($request->get('inquiry'))
            );
        }

        if ($request->get('customer')) {
            $offerTemplate->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        return $this->render(
            'CrmpAcquisitionBundle:Offer:index.html.twig',
            array(
                'offers' => $this->findAllSimilar($offerTemplate),
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
            // inquiry given: pre-fill form
            $inquiry = $this->get('crmp.inquiry.repository')->find($request->get('inquiry'));

            $offer->setInquiry($inquiry);

            if ($inquiry->getCustomer()) {
                $offer->setCustomer($inquiry->getCustomer());
            }
        }

        if (! $offer->getCustomer() && $request->get('customer')) {
            // customer given: pre-fill form
            $customer = $this->get('crmp.customer.repository')->find($request->get('customer'));

            $offer->setCustomer($customer);
        }

        $offer->setStatus(0);

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('crmp.offer.repository')->update($offer);

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
     * Updates information about an offer.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request)
    {
        $offerRepository = $this->getMainRepository();

        /** @var Offer $offer */
        $offer = $offerRepository->find($request->get('id'));

        if (! $offer) {
            // offer not found => this is odd
            return new Response('', 500);
        }

        if (null !== $request->get('status')) {
            // received value for status => update offer status
            $offer->setStatus($request->get('status'));
            $this->getMainRepository()->persist($offer);
        }

        return $this->redirectToRoute('crmp_acquisition_offer_show', ['id' => $offer->getId()]);
    }

    /**
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        return $this->get('crmp.offer.repository');
    }
}
