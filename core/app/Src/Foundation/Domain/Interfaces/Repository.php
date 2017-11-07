<?php namespace Huifang\Src\Foundation\Domain\Interfaces;

interface Repository
{
    /**
     * Save an entity to repository.
     *
     * @param \Huifang\Src\Foundation\Domain\Entity $entity
     */
    public function save($entity);

    /**
     * Fetch an entity from repository by its identity.
     *
     * @param mixed $id
     * @param bool  $throws Whether throws an EntityNotFound exception.
     * @return \Huifang\Src\Foundation\Domain\Entity|null
     *
     * @throws \Huifang\Src\Foundation\Domain\Exceptions\EntityNotFound
     */
    public function fetch($id, $throws = false);

}