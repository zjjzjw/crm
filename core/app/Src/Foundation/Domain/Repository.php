<?php namespace Huifang\Src\Foundation\Domain;

use Huifang\Src\Foundation\Domain\Exceptions\EntityNotFound;
use Huifang\Src\Foundation\Domain\Interfaces\Repository as RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    /**
     * Reconstitute an entity from persistence.
     *
     * @param mixed $id
     * @param array $params Additional params.
     * @return \Huifang\Src\Foundation\Domain\Entity
     */
    abstract protected function reconstitute($id, $params = []);

    /**
     * Store an entity into persistence.
     *
     * @param \Huifang\Src\Foundation\Domain\Entity $entity
     */
    abstract protected function store($entity);

    /**
     * Save an entity to repository and then publish its events.
     *
     * @param \Huifang\Src\Foundation\Domain\Entity $entity
     */
    public function save($entity)
    {
        $this->store($entity);
        $entity->stored();
        $entity->publishEvents();
    }

    /**
     * Fetch an entity from repository by its identity.
     *
     * @param mixed $id
     * @param array $params Additional params.
     * @param bool  $throws Whether throws an EntityNotFound exception.
     * @return \Huifang\Src\Foundation\Domain\Entity|null
     *
     * @throws \Huifang\Src\Foundation\Domain\Exceptions\EntityNotFound
     */
    public function fetch($id, $params = [], $throws = false)
    {
        $entity = $this->reconstitute($id, $params);
        if (isset($entity)) {
            $entity->stored();
        } elseif ($throws) {
            throw new EntityNotFound(static::class, $id);
        }

        return $entity;
    }

}