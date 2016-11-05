<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Panels\Settings\General;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Crmp\CrmBundle\Entity\Address;
use Crmp\CrmBundle\Form\AddressType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Managing addresses.
 *
 * The CRM-Bundle brings you two main entities with customers and addresses.
 *
 * @Route("/address")
 */
class AddressController extends AbstractCrmpController
{
    const ENTITY_NAME  = 'address';
    const FORM_TYPE    = AddressType::class;
    const ROUTE_DELETE = 'crmp_crm_address_delete';
    const ROUTE_INDEX  = 'crmp_crm_address_index';
    const ROUTE_SHOW   = 'crmp_crm_address_show';
    const VIEW_EDIT    = 'CrmpCrmBundle:Address:edit.html.twig';
    const VIEW_SHOW    = 'CrmpCrmBundle:Address:show.html.twig';

    /**
     * Lists all addresses.
     *
     * To list all addresses go to the address overview.
     * Addresses can be filtered by customer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $address = new Address();

        if ($request->get('customer')) {
            $address->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        return $this->render(
            'CrmpCrmBundle:Address:index.html.twig',
            array(
                'addresses' => $this->findAllSimilar($address),
            )
        );
    }

    /**
     * Creates a new Address entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $address = new Address();

        if ($request->get('customer')) {
            // customer given => pre-fill form
            $address->setCustomer(
                $this->get('crmp.customer.repository')->find($request->get('customer'))
            );
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUpdatedBy($this->getUser());
            $this->getMainRepository()->persist($address);

            return $this->redirectToRoute('crmp_crm_address_show', array('id' => $address->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Address:new.html.twig',
            array(
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
        return $this->get('crmp.address.repository');
    }
}
