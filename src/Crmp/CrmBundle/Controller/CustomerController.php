<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
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
class CustomerController extends AbstractRepositoryController
{
    const ENTITY_NAME  = 'customer';
    const FORM_TYPE    = CustomerType::class;
    const ROUTE_DELETE = 'crmp_crm_customer_delete';
    const ROUTE_INDEX  = 'crmp_crm_customer_index';
    const ROUTE_SHOW   = 'crmp_crm_customer_show';
    const VIEW_EDIT    = 'CrmpCrmBundle:Customer:edit.html.twig';
    const VIEW_SHOW    = 'CrmpCrmBundle:Customer:show.html.twig';

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
            $this->getMainRepository()->persist($customer);

            return $this->redirectToRoute('crmp_crm_customer_show', array('id' => $customer->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Customer:new.html.twig',
            array(
                'form'     => $form->createView(),
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
        return $this->get('crmp.customer.repository');
    }
}
