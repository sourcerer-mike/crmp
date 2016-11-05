<?php

namespace Crmp\CrmBundle\Controller;

use Crmp\AccountingBundle\Controller\InvoiceController;
use Crmp\AccountingBundle\Entity\Invoice;
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
    const ENTITY_NAME  = null;
    const FORM_TYPE    = null;
    const ROUTE_DELETE = null;
    const ROUTE_INDEX  = null;
    const ROUTE_SHOW   = null;
    const VIEW_EDIT    = null;
    const VIEW_SHOW    = null;

    /**
     * Assert that all constants are given.
     */
    public function __construct()
    {
        if (! static::ENTITY_NAME) {
            throw new \LogicException('Please define the '.get_class($this).'::ENTITY_NAME constant.');
        }

        if (! static::FORM_TYPE) {
            throw new \LogicException('Please define the '.get_class($this).'::FORM_TYPE constant.');
        }

        if (! static::ROUTE_DELETE) {
            throw new \LogicException('Please define the '.get_class($this).'::ROUTE_DELETE constant.');
        }

        if (! static::ROUTE_INDEX) {
            throw new \LogicException('Please define the '.get_class($this).'::ROUTE_INDEX constant.');
        }

        if (! static::ROUTE_SHOW) {
            throw new \LogicException('Please define the '.get_class($this).'::ROUTE_SHOW constant.');
        }

        if (! static::VIEW_EDIT) {
            throw new \LogicException('Please define the '.get_class($this).'::VIEW_EDIT constant.');
        }

        if (! static::VIEW_SHOW) {
            throw new \LogicException('Please define the '.get_class($this).'::VIEW_SHOW constant.');
        }
    }

    /**
     * Deletes an entity.
     *
     * You should not delete entities as this is needed for later reviews.
     * Anyways CRMP allows you to delete entities as if they never existed.
     * Please be careful deleting things.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $entity = $this->getMainRepository()->find($request->get('id'));

        $form   = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getMainRepository()->remove($entity);
        }

        return $this->redirectToRoute(static::ROUTE_INDEX);
    }

    /**
     * Change a single existing entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request)
    {
        if (! $request->get('id')) {
            throw new \InvalidArgumentException('Please provide an ID.');
        }

        $entity = $this->getMainRepository()->find($request->get('id'));

        $editForm = $this->createForm(static::FORM_TYPE, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getMainRepository()->persist($entity);

            return $this->redirectToRoute(static::ROUTE_SHOW, array('id' => $entity->getId()));
        }

        return $this->render(
            static::VIEW_EDIT,
            array(
                static::ENTITY_NAME => $entity,
                'edit_form'         => $editForm->createView(),
                'delete_form'       => $this->createDeleteForm($entity)->createView(),
            )
        );
    }

    /**
     * Look at a single invoice.
     *
     * Recheck a single invoice calling "/invoice/{id}".
     *
     * @param Request $request
     *
     * @return Response
     *
     */
    public function showAction(Request $request)
    {
        $entity = $this->getMainRepository()->find($request->get('id'));

        $deleteForm = $this->createDeleteForm($entity);

        return $this->render(
            static::VIEW_SHOW,
            array(
                static::ENTITY_NAME => $entity,
                'delete_form'       => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete an entity.
     *
     * @param object $entity The entity which shall be deleted.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($entity)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl(static::ROUTE_DELETE, array('id' => $entity->getId())))
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
    protected function findAllSimilar($searchEntity, $request = null)
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
        $this->container->get('crmp.controller.render.parameters')->exchangeArray($parameters);

        return parent::render($view, $parameters, $response);
    }
}
