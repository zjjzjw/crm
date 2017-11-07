<?php

namespace Huifang\Service\Project;

use Carbon\Carbon;
use Huifang\Service\Role\UserService;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderEntity;
use Huifang\Src\Project\Domain\Model\ProjectCorpUserEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Infra\Repository\ProjectCorpUserRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Huifang\Web\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    /**
     * @param ProjectSpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getTouchProjectList(ProjectSpecification $spec, $per_page)
    {
        $data = [];
        $project_repository = new ProjectRepository();
        $paginate = $project_repository->search($spec, $per_page);

        $items = [];
        /**
         * @var int                  $key
         * @var ProjectEntity        $project_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $project_entity) {
            $item = $project_entity->toArray();
            $item['text'] = $project_entity->project_name;
            $item['time'] = Carbon::parse($project_entity->created_at)->format('m-d H:i');
            $item['url'] = route('project.detail', ['id' => $project_entity->id]);
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * @param ProjectSpecification $pec
     * @param int                  $limit
     * @return array
     */
    public function getProjectListByKeyword($spec, $limit = 20)
    {
        $items = [];
        $project_repository = new ProjectRepository();
        $project_entities = $project_repository->getProjectListByKeyword($spec, $limit);
        foreach ($project_entities as $project_entity) {
            $item = $project_entity->toArray();
            $item['name'] = $project_entity->project_name;
            $item['time'] = Carbon::parse($project_entity->created_at)->format('m-d H:i');
            $item['url'] = route('project.detail', ['id' => $project_entity->id]);
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getProjectInfo($id)
    {
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($id);
        $data = $project_entity->toArray();
        $city_repository = new CityRepository();
        $city_entity = $city_repository->fetch($project_entity->city_id);
        if ($city_entity) {
            $data['city'] = $city_entity->toArray();
        }
        $province_repository = new ProvinceRepository();
        $province_repository->fetch($project_entity->province_id);
        $province_entity = $province_repository->fetch($project_entity->province_id);
        if ($province_entity) {
            $data['province'] = $province_entity->toArray();
        }
        $data['signed_at'] = Carbon::parse($project_entity->signed_at)->format('Y-m-d');
        //项目负者人
        $user_repository = new UserRepository();
        $data['project_user'] = [];
        if (!empty($project_entity->user_id)) {
            $user_entity = $user_repository->fetch($project_entity->user_id);
            $data['project_user'] = $user_entity->toArray();
        }

        $data['project_corp_users'] = [];
        $data['project_corp_user_ids'] = [];
        $data['project_corp_user_names'] = [];
        if (!empty($project_entity->project_corp_user_ids)) {
            $project_corp_users = [];
            $user_entities = $user_repository->getUserByIds($project_entity->project_corp_user_ids);
            foreach ($user_entities as $user_entity) {
                $project_corp_users[] = $user_entity->toArray();
            }
            $data['project_corp_users'] = $project_corp_users;
            $data['project_corp_user_ids'] = collect($project_corp_users)->pluck('id')->toArray();
            $data['project_corp_user_names'] = collect($project_corp_users)->pluck('name')->toArray();
        }
        return $data;
    }

    /**
     * 得到合伙项目IDS
     * @param int $user_id
     * @return array|int
     */
    public function getCorpUserProjectIds($user_id)
    {
        $project_ids = [];
        $project_corp_user_repository = new ProjectCorpUserRepository();
        $project_corp_user_entities = $project_corp_user_repository->getProjectCorpUsersByUserId($user_id);
        /** @var ProjectCorpUserEntity $project_corp_user_entity */
        foreach ($project_corp_user_entities as $project_corp_user_entity) {
            $project_ids[] = $project_corp_user_entity->project_id;
        }
        return $project_ids;
    }


    /**
     * 得到个人的任务清单（目标障碍）
     * @param User   $user
     * @param Carbon $start_time
     * @param Carbon $end_time
     * @return array
     */
    public function getProjectTaskManifestByDate($user, $start_time, $end_time)
    {
        $projects = [];
        $project_repository = new ProjectRepository();
        $project_specification = new ProjectSpecification();
        $project_specification->user_id = $user->id;
        $project_specification->start_time = $start_time;
        $project_specification->end_time = $end_time;
        $project_entities = $project_repository->getProjectListByKeyword($project_specification);

        $project_aim_service = new ProjectAimService();
        foreach ($project_entities as $project_entity) {
            $item = $project_entity->toArray();
            $aim_hinders = $project_aim_service->getProjectAimHindersByProjectIdAndAimId($project_entity->id, 0);
            /** @var ProjectAimHinderEntity $aim_hinder_entity */
            foreach ($aim_hinders as $aim_hinder) {
                $item['hinders'][] = $aim_hinder;
            }
            $projects[] = $item;
        }
        return $projects;
    }


    public function getManagerProjectTaskManifestByDate($user, $start_time, $end_time)
    {
        $projects = [];
        $user_ids = [];
        $user_service = new UserService();
        $manager_users = $user_service->getSearchUsers($user->company_id, $user->id);
        foreach ($manager_users as $manager_user) {
            $user_ids[] = $manager_user['id'];
        }
        $user_ids[] = $user->id;

        $project_repository = new ProjectRepository();

        $project_specification = new ProjectSpecification();
        $project_specification->user_ids = $user_ids;
        $project_specification->start_time = $start_time;
        $project_specification->end_time = $end_time;

        $project_entities = $project_repository->getProjectListByKeyword($project_specification);

        $project_aim_service = new ProjectAimService();
        foreach ($project_entities as $project_entity) {
            $item = $project_entity->toArray();
            $aim_hinders = $project_aim_service->getProjectAimHindersByProjectIdAndAimId($project_entity->id, 0);
            /** @var ProjectAimHinderEntity $aim_hinder_entity */
            foreach ($aim_hinders as $aim_hinder) {
                $item['hinders'][] = $aim_hinder;
            }
            $projects[] = $item;
        }
        return $projects;
    }


    /**
     * @return array
     */
    public function getTaskManifestMonths()
    {
        $months = [];
        $start_month = Carbon::createFromFormat('Y-m-d', '2017-04-01');
        $end_month = Carbon::now();
        for ($month = $start_month; $month < $end_month; $month->addMonth()) {
            $months[$month->format('Ym')] = $month->format('Y月m日');
        }
        return $months;
    }

}

