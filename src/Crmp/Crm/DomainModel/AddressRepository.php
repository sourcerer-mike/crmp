<?php


namespace Crmp\Crm\DomainModel;


interface AddressRepositoryInterface
{
    public function find($id);

    public function findAll();

    public function add(Address $address);

    public function remove(Address $address);
}