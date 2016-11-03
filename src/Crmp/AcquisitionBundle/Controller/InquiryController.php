<?php

namespace Crmp\AcquisitionBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Controller\AbstractCrmpController;
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
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    protected function getMainRepository()
    {
        return $this->get('crmp.inquiry.repository');
    }
}
