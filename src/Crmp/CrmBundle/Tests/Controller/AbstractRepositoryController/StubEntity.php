<?php


namespace Crmp\CrmBundle\Tests\Controller\AbstractRepositoryController;


class StubEntity
{
    protected $something;

    /**
     * @return mixed
     */
    public function getSomething()
    {
        return $this->something;
    }

    /**
     * @param mixed $something
     */
    public function setSomething($something)
    {
        $this->something = $something;
    }
}