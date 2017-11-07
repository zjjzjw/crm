<?php namespace Huifang\Src\Project\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;

interface ProjectCorpUserInterface extends Repository
{
    /**
     * @param int $user_id
     * @return mixed
     */
    public function getProjectCorpUsersByUserId($user_id);
}