<?php namespace Huifang\Web\Http\Controllers\Project;

use Carbon\Carbon;
use Huifang\Service\Card\CardService;
use Huifang\Service\Project\ProjectService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Domain\Model\ProjectVolumeType;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Role\Domain\Model\UserSpecification;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\ProjectSearchForm;
use Huifang\Web\User;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    /**
     * 全部项目列表
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \View
     */
    public function projectList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $this->title = '全部项目';
        $this->file_css = 'project.list';
        $this->file_js = 'project.list';
        $user = $this->getUser();

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company_id, 1);
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        //加入自己
        $user_ids[] = 1;
        $request->merge(['user_ids' => $user_ids]);
        $request->merge(['company_id' => $user->company_id]);
        $data = $this->getListData($request, $form);

        $data['search_users'] = $search_users;

        $data['route_name'] = 'project.list';
        return $this->view('touch.project.list', $data);
    }

    /**
     * 我的项目列表
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \View
     */
    public function projectIndividualList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $this->title = '我的项目';
        $this->file_css = 'project.list';
        $this->file_js = 'project.list';
        $user = $this->getUser();
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company_id]);

        //体量搜索
        $data = $this->getListData($request, $form);
        $data['route_name'] = 'project.individual.list';

        return $this->view('touch.project.list', $data);
    }

    /**
     * 合伙项目列表
     * @param Request           $request
     * @param ProjectSearchForm $form
     */
    public function projectPartnerList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $this->title = '合伙项目';
        $this->file_css = 'project.list';
        $this->file_js = 'project.list';
        $user = $this->getUser();
        //得到合伙项目ID
        $project_service = new ProjectService();
        $project_ids = $project_service->getCorpUserProjectIds($user->id);

        $request->merge(['project_ids' => $project_ids]);
        $request->merge(['company_id' => $user->company_id]);
        //体量搜索
        $data = $this->getListData($request, $form);

        $data['route_name'] = 'project.partner.list';
        return $this->view('touch.project.list', $data);
    }

    public function projectDetail(Request $request, $id)
    {
        $this->file_css = 'project.detail';
        $this->file_js = 'project.detail';
        $this->title = '项目管理';

        $project_service = new ProjectService();
        $data = $project_service->getProjectInfo($id);
        //得到项目档案
        $project_file_repository = new ProjectFileRepository();
        $project_file_entity = $project_file_repository->getProjectFileByProjectId($id);
        if (isset($project_file_entity)) {
            $data['project_file'] = $project_file_entity->toArray();
        }
        return $this->view('touch.project.detail', $data);
    }

    public function projectEdit(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'project.edit';
        $this->file_js = 'project.edit';
        if (!empty($id)) {
            $this->title = '编辑项目';
        } else {
            $this->title = '创建项目';
        }
        $user = $this->getUser();
        if (!empty($id)) {
            $project_service = new ProjectService();
            $data = $project_service->getProjectInfo($id);
        }
        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForProject();

        $user_service = new UserService();
        $owner_users = $user_service->getUsersByCompanyId($user->company->id);
        $data['owner_users'] = $owner_users;

        //得到项目共享人
        $user_service = new UserService();
        $cooperation_departs = $user_service->getProjectCooperationUsers($user->company->id);
        $data['cooperation_departs'] = $cooperation_departs;


        return $this->view('touch.project.edit', $data);
    }


    protected function getListData(Request $request, ProjectSearchForm $form)
    {
        $per_page = $request->get('per_page', 10);
        $form->validate($request->all());

        $project_service = new ProjectService();
        $data = $project_service->getTouchProjectList($form->project_specification, 10);

        $appends = $this->getPageAppends($form->project_specification);
        //ajax 分页需要
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;
        //体量搜索
        $project_volume_types = ProjectVolumeType::acceptableEnums();
        $data['project_volume_types'] = $project_volume_types;
        $data['appends'] = $appends;

        $choose = [
            'title'        => $this->title,
            'url'          => route('project.edit', ['id' => 0]),
            'choose_items' => [
                [
                    'url'  => route('project.list'),
                    'name' => '全部项目',
                ],
                [
                    'url'  => route('project.individual.list'),
                    'name' => '我的项目',
                ],
                [
                    'url'  => route('project.partner.list'),
                    'name' => '合伙项目',
                ],
            ],
        ];
        $data['choose'] = $choose;
        return $data;
    }


    /**
     * @param ProjectSpecification $spec
     * @return array
     */
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

    //任务清单
    public function projectTaskManifest()
    {
        $data = [];
        $this->title = '任务清单';
        $this->file_css = 'project.task-manifest';
        $this->file_js = 'project.task-manifest';

        $user = $this->getUser();

        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;

        $user_service = new UserService();
        $depart_users = $user_service->getAssignUsers($user->company->id, $user->id);
        $data['depart_users'] = $depart_users;

        return $this->view('touch.project.task-manifest', $data);
    }


    /**
     * 任务列表
     * @param $user_id
     * @return \View
     */
    public function projectTaskManifestList($user_id)
    {
        $data = [];
        $this->title = '任务列表';
        $this->file_css = 'project.task-manifest-list';

        $choose = [
            'title' => $this->title,
        ];
        $data['choose'] = $choose;
        $project_service = new ProjectService();
        $months = $project_service->getTaskManifestMonths();
        $data['months'] = $months;
        $data['user_id'] = $user_id;

        return $this->view('touch.project.task-manifest-list', $data);
    }

    /**
     * 任务详情
     * @param $user_id
     * @return \View
     */
    public function projectTaskManifestDetail(Request $request, $user_id)
    {
        $data = [];
        $this->title = '任务详情';
        $this->file_css = 'project.task-manifest-detail';

        $month = $request->get('month');
        $project_service = new ProjectService();

        $user = \Huifang\Web\User::find($user_id);

        $start_time = Carbon::createFromFormat('Ym', $month)->startOfMonth();
        $end_time = Carbon::createFromFormat('Ym', $month)->endOfMonth();

        $project_list = $project_service->getProjectTaskManifestByDate($user,
            $start_time, $end_time);

        $data['project_list'] = $project_list;

        return $this->view('touch.project.task-manifest-detail', $data);
    }
}