<?php

namespace Crmp\AcquisitionBundle\Controller;

use Crmp\AcquisitionBundle\Form\InquiryType;
use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractCrmpController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    const ENTITY_NAME  = 'inquiry';
    const FORM_TYPE    = InquiryType::class;
    const ROUTE_DELETE = 'crmp_acquisition_inquiry_delete';
    const ROUTE_INDEX  = 'crmp_acquisition_inquiry_index';
    const ROUTE_SHOW   = 'crmp_acquisition_inquiry_show';
    const VIEW_EDIT    = 'CrmpAcquisitionBundle:Inquiry:edit.html.twig';
    const VIEW_SHOW    = 'CrmpAcquisitionBundle:Inquiry:show.html.twig';

    /**
     * Lists all inquiry entities.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $inquiry = new Inquiry();

        if ($request->get('customer')) {
            $inquiry->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        if ($request->get('status')) {
            $inquiry->setStatus($request->get('status'));
        }

        return $this->render(
            'CrmpAcquisitionBundle:Inquiry:index.html.twig',
            [
                'inquiries' => $this->findAllSimilar($inquiry),
            ]
        );
    }

    /**
     * Creates a new Inquiry entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $inquiry = new Inquiry();
        $inquiry->setStatus(0);

        if ($request->get('customer')) {
            // customer given => pre-fill form
            $inquiry->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        $inquiry->setInquiredAt(new \DateTime());

        $form = $this->createForm(InquiryType::class, $inquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getMainRepository()->persist($inquiry);

            return $this->redirectToRoute('crmp_acquisition_inquiry_show', array('id' => $inquiry->getId()));
        }

        $this->container;

        return $this->render(
            'CrmpAcquisitionBundle:Inquiry:new.html.twig',
            [
                'form'    => $form->createView(),
            ]
        );
    }

    /**
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        return $this->get('crmp.inquiry.repository');
    }
}
