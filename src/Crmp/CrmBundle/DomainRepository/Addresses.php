<?php


namespace Crmp\CrmBundle\DomainRepository;

use Crmp\Crm\DomainModel\Address;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * AddressRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Addresses implements \Crmp\Crm\DomainModel\AddressRepositoryInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    public function add(Address $address)
    {
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findAll()
    {
        return $this->container->get('doctrine.orm.entity_manager')->getRepository('CrmpCrmBundle:Address')->findAll();
    }

    public function remove(Address $address)
    {
        $this->container->get('doctrine.orm.entity_manager')->getRepository('CrmpCrmBundle:Address');
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
