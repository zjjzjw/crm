<?php namespace Huifang\Mobi\Http\Controllers\Api\Project;

use Huifang\Mobi\Http\Controllers\BaseController;
use Huifang\Mobi\Src\Forms\Project\ProjectDeleteForm;
use Huifang\Mobi\Src\Forms\Project\ProjectSearchForm;
use Huifang\Mobi\Src\Forms\Project\ProjectStoreForm;
use Huifang\Mobi\Src\Service\Project\ProjectMobiService;
use Huifang\Mobi\Src\Service\Role\UserMobiService;
use Huifang\Service\Role\TokenService;
use Huifang\Service\Role\UserService;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Illuminate\Http\Request;


class ProjectController extends BaseController
{

    /**
     * 全部项目列表
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $user_entity = TokenService::getUserEntity();
        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user_entity->company_id, $user_entity->id);
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        //加入自己
        $user_ids[] = $user_entity->id;
        $request->merge(['user_ids' => $user_ids]);
        $request->merge(['company_id' => $user_entity->company_id]);
        $data = $this->getListData($request, $form);
        //$data['search_users'] = $search_users;

        $data['route_name'] = 'project.list';
        return response()->json(format_data($data), 200);
    }

    /**
     * 我的项目列表
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectIndividualList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $user_entity = TokenService::getUserEntity();
        $request->merge(['user_id' => $user_entity->id]);
        $request->merge(['company_id' => $user_entity->company_id]);

        //体量搜索
        $data = $this->getListData($request, $form);
        $data['route_name'] = 'project.individual.list';

        return response()->json(format_data($data), 200);
    }

    /**
     * 合伙项目列表
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectPartnerList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $user_entity = TokenService::getUserEntity();
        //得到合伙项目ID
        $project_service = new ProjectMobiService();
        $project_ids = $project_service->getCorpUserProjectIds($user_entity->id);

        $request->merge(['project_ids' => $project_ids]);
        $request->merge(['company_id' => $user_entity->company_id]);
        //体量搜索
        $data = $this->getListData($request, $form);

        $data['route_name'] = 'project.partner.list';
        return response()->json(format_data($data), 200);
    }

    public function projectDetail(Request $request, $id)
    {
        $project_service = new ProjectMobiService();
        $data = $project_service->getProjectInfo($id);
        //得到项目档案
        $project_file_repository = new ProjectFileRepository();
        $project_file_entity = $project_file_repository->getProjectFileByProjectId($id);
        if (isset($project_file_entity)) {
            //$data['project_file'] = $project_file_entity->toArray();
        }
        return response()->json(format_data($data), 200);
    }

    protected function getListData(Request $request, ProjectSearchForm $form)
    {
        $per_page = $request->get('per_page', 10);
        $form->validate($request->all());

        $project_service = new ProjectMobiService();
        $data = $project_service->getTouchProjectList($form->project_specification, $per_page);

        $appends = $this->getPageAppends($form->project_specification);
        //ajax 分页需要
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;

        $data['appends'] = $appends;

        return $data;
    }

    public function projectFilter()
    {
        $data = [];
        $user_entity = TokenService::getUserEntity();
        //体量搜索
        $project_volume_types = ProjectVolumeType::acceptableEnums();
        $project_volume_type_array = [];
        foreach ($project_volume_types as $key => $project_volume_type) {
            $project_volume_type_arr['id'] = $key;
            $project_volume_type_arr['name'] = $project_volume_type;
            $project_volume_type_array[] = $project_volume_type_arr;
        }
        $data['project_volume_types'] = $project_volume_type_array;
        $user_service = new UserMobiService();
        $search_users = $user_service->getSearchUsers($user_entity->company_id, $user_entity->id);
        /*$choose = [
            'choose_items' => [
                [
                    'url'  => route('api.project.list'),
                    'name' => '全部项目',
                ],
                [
                    'url'  => route('api.project.individual.list'),
                    'name' => '我的项目',
                ],
                [
                    'url'  => route('api.project.partner.list'),
                    'name' => '合伙项目',
                ],
            ],
        ];
        $data['choose'] = $choose;*/
        $data['search_users'] = $search_users;
        return response()->json(format_data($data), 200);
    }


    protected function getPageAppends(ProjectSpecification $spec)
    {
        $appends = [];
        if ($spec->project_volume_type) {
            $appends['project_volume_type'] = $spec->project_volume_type;
        }
        if ($spec->city_id) {
            $appends['city_id'] = $spec->city_id;
        }
        if ($spec->province_id) {
            $appends['province_id'] = $spec->province_id;
        }
        if ($spec->user_id) {
            $appends['user_id'] = $spec->user_id;
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        if ($spec->start_time) {
            $appends['start_time'] = $spec->start_time->toDateString();
        }
        if ($spec->end_time) {
            $appends['end_time'] = $spec->end_time->toDateString();
        }
        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }
        return $appends;
    }


    public function getKeyword(Request $request)
    {
        $data = [];
        $user_entity = TokenService::getUserEntity();
        $keyword = $request->get('keyword', '');
        $type = $request->get('type', '');
        $user_ids = [];
        if ($type == 'individual') {
            $user_ids[] = $user_entity->id;
        } elseif ($type == 'all') {
            $user_ids = false;
        }
        $project_service = new ProjectMobiService();
        if ($type == 'partner') {
            $user_entity = TokenService::getUserEntity();
            //得到合伙项目ID
            $project_service = new ProjectMobiService();
            $project_ids = $project_service->getCorpUserProjectIds($user_entity->id);
            $data = $project_service->getProjectListByIds($project_ids);
        } else {
            $data = $project_service->getProjectListByKeyword($keyword, $user_ids, $user_entity->company_id);
        }
        return response()->json(format_data($data), 200);
    }


    /**
     * @param Request          $request
     * @param ProjectStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectStore(Request $request, ProjectStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_repository = new ProjectRepository();
        $project_repository->save($form->project_entity);
        $data['success'] = true;
        return response()->json(format_data($data), 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectDelete(Request $request, ProjectDeleteForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_repository = new ProjectRepository();
        $project_repository->delete($form->id);
        $data['success'] = true;
        return response()->json(format_data($data), 200);
    }
}