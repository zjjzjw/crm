<?php namespace Huifang\Mobi\Src\Service\Project;


use Huifang\Service\Company\DepartService;
use Huifang\Service\Role\TokenService;
use Huifang\Src\Project\Domain\Model\ProjectCorpUserEntity;
use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Project\Infra\Repository\ProjectCorpUserRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Domain\Model\DataType;
use Huifang\Src\Role\Domain\Model\UserDataEntity;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\UserDataRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Huifang\Src\Sale\Domain\Model\SaleCloseStatus;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class ProjectMobiService
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
            $item['url'] = '';
            $items[] = $item;
        }

        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
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
            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($project_entity->user_id);
            $data['project_user']['id'] = $user_entity->id;
            $data['project_user']['name'] = $user_entity->name;
        }

        $data['project_corp_user_names'] = [];
        if (!empty($project_entity->project_corp_user_ids)) {
            $project_corp_users = [];
            $user_entities = $user_repository->getUserByIds($project_entity->project_corp_user_ids);
            foreach ($user_entities as $user_entity) {
                $project_corp_users[] = $user_entity->toArray();
            }
            //$data['project_corp_users']['id'] = collect($project_corp_users)->pluck('id')->toArray();
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

    public function getProjectListByKeyword($keyword, $user_ids, $company_id)
    {
        $data = [];
        $project_repository = new ProjectRepository();
        $project_entities = $project_repository->getProjectListByKeywords($keyword, $user_ids, $company_id);
        /** @var ProjectEntity $project_entity */
        foreach ($project_entities as $project_entity) {
            $item['id'] = $project_entity->id;
            $item['name'] = $project_entity->project_name;
            $data[] = $item;
        }
        return $data;
    }

    public function getProjectListByIds($ids)
    {
        $data = [];
        $project_repository = new ProjectRepository();
        $project_entities = $project_repository->getProjectListByIds($ids);
        /** @var ProjectEntity $project_entity */
        foreach ($project_entities as $project_entity) {
            $item['id'] = $project_entity->id;
            $item['name'] = $project_entity->project_name;
            $data[] = $item;
        }
        return $data;
    }
}
