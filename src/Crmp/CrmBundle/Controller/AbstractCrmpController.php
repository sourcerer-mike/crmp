<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\CoreDomain\RepositoryInterface;
use Crmp\CrmBundle\Panels\Settings\General;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract controller for CRMP.
 *
 * Other controller shall inherit from this
 * because it registers the current used parameters in the DI container.
 *
 * @package Crmp\CrmBundle\Controller
 */
abstract class AbstractCrmpController extends Controller
{
    /**
     * Deletes an entity.
     *
     * You should not delete entities as this is needed for later reviews.
     * Anyways CRMP allows you to delete entities as if they never existed.
     * Please be careful deleting things.
     *
     * @param Request $request
     * @param object  $entity
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getMainRepository()->remove($entity);
        }

        return $this->redirectToRoute(InvoiceController::ROUTE_INDEX);
    }

    /**
     * Creates a form to delete a Invoice entity.
     *
     * @param object $invoice The Invoice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($invoice)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl(InvoiceController::ROUTE_DELETE, array('id' => $invoice->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Fetch similar entities with pagination.
     *
     * Fetches similar entities
     * and respects pagination as given by request.
     *
     * @param object  $searchEntity
     * @param Request $request The request that came in.
     *
     * @return \object[]
     *
     */
    protected function fetchSimilar($searchEntity, $request = null)
    {
        /** @var RepositoryInterface $repository */
        $repository = $this->getMainRepository();

        $start = null;

        // Fetch URLs like ?start=42
        if ($request instanceof Request && $request->get('start')) {
            $start = $request->get('start');
        }

        $order = [];

        // Fetch URLs like ?order[foo]=asc
        if ($request instanceof Request && $request->get('order')) {
            foreach ($request->get('order') as $field => $sort) {
                $order[] = [$field => $sort];
            }
        }

        return $repository->findAllSimilar($searchEntity, $this->getListLimit(), $start, $order);
    }

    protected function getListLimit()
    {
        return $this->get('crmp.setting.repository')->get(General::LIST_LIMIT, $this->getUser());
    }

    /**
     * Repository suitable for the controller.
     *
     * @return RepositoryInterface
     */
    abstract protected function getMainRepository();

    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $this->container->set('crmp.controller.render.parameters', new \ArrayObject($parameters));

        return parent::render($view, $parameters, $response);
    }
}
