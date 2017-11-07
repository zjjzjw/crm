<?php

namespace Huifang\Service\Project;

use Carbon\Carbon;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectFileService
{
    public function getProjectFileInfo($id)
    {
        $data = [];
        $project_file_repository = new ProjectFileRepository();
        $project_file_entity = $project_file_repository->fetch($id);
        if (isset($project_file_entity)) {
            $data = $project_file_entity->toArray();
        }
        return $data;
    }

}

