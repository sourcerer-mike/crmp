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
    /**
     * Lists all addresses.
     *
     * To list all addresses go to the address overview.
     * Addresses can be filtered by customer.
     *
     * @Route("/", name="crmp_crm_address_index")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $repo = $this->get('crmp.address.repository');
        $addresses = $repo->findAll($this->getListLimit());

        if ($request->get('customer')) {
            $addresses = $repo->findBy(
                [
                    'customer' => $request->get('customer'),
                ]
            );
        }

        return $this->render(
            'CrmpCrmBundle:Address:index.html.twig',
            array(
                'addresses' => $addresses,
            )
        );
    }

    /**
     * Creates a new Address entity.
     *
     * @Route("/new", name="crmp_crm_address_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $address = new Address();

        if ($request->get('customer')) {
            // customer given: pre-fill form
            $customer = $this->getDoctrine()->getRepository('CrmpCrmBundle:Customer')->find($request->get('customer'));

            $address->setCustomer($customer);
        }

        $form = $this->createForm('Crmp\CrmBundle\Form\AddressType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute('crmp_crm_address_show', array('id' => $address->getId()));
        }

        return $this->render(
            'CrmpCrmBundle:Address:new.html.twig',
            array(
                'address' => $address,
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
