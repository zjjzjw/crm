<?php namespace Huifang\Web\Http\Controllers\Api\Project;

use Huifang\Service\Project\ProjectService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Sale\SaleService;

use Huifang\Src\Project\Domain\Model\ProjectSpecification;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\ProjectDeleteForm;
use Huifang\Web\Src\Forms\Project\ProjectSearchForm;
use Huifang\Web\Src\Forms\Project\ProjectStoreForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleStoreForm;
use Huifang\Web\User;
use Illuminate\Http\Request;


class ProjectController extends BaseController
{
    /**
     * 全部项目列表API
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);

        $user = $this->getUser();
        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company_id, $user->id);
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        //加入自己
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);
        $request->merge(['company_id' => $user->company_id]);

        $form->validate($request->all());
        $project_service = new ProjectService();
        $data = $project_service->getTouchProjectList($form->project_specification, $per_page);

        return response()->json($data, 200);
    }

    /**
     * 我的项目列表API
     * @param Request           $request
     * @param ProjectSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectIndividualList(Request $request, ProjectSearchForm $form)
    {
        $data = [];
        $per_page = $request->get('per_page', 10);

        $user = $this->getUser();
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company_id]);

        $form->validate($request->all());
        $project_service = new ProjectService();
        $data = $project_service->getTouchProjectList($form->project_specification, $per_page);

        return response()->json($data, 200);
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
        $per_page = $request->get('per_page', 10);
        $user = $this->getUser();
        $project_service = new ProjectService();
        $project_ids = $project_service->getCorpUserProjectIds($user->id);
        $request->merge(['project_ids' => $project_ids]);
        $request->merge(['company_id' => $user->company_id]);
        $form->validate($request->all());
        $data = $project_service->getTouchProjectList($form->project_specification, $per_page);
        return response()->json($data, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjectListByKeyword(Request $request)
    {
        $data = [];
        $keyword = $request->get('keyword', '');
        $type = $request->get('type', '');
        $spec = new ProjectSpecification();
        $spec->keyword = $keyword;
        $user = $this->getUser();
        //自己
        if ($type == 'project.individual.list') {
            $spec->user_id = $user->id;
            //合伙
        } else if ($type == 'project.partner.list') {
            $project_service = new ProjectService();
            $project_ids = $project_service->getCorpUserProjectIds($user->id);
            $spec->project_ids = $project_ids;
            //全部
        } else {
            $user_service = new UserService();
            $search_users = $user_service->getSearchUsers($user->company_id, $user->id);
            $user_ids = [];
            foreach ($search_users as $search_user) {
                $user_ids[] = $search_user['id'];
            }
            //加入自己
            $user_ids[] = $user->id;
            $spec->user_ids = $user_ids;
        }
        if (!empty($keyword)) {
            $project_service = new ProjectService();
            $data = $project_service->getProjectListByKeyword($spec, 10);
        }
        return response()->json($data, 200);
    }

    /**
     * @param Request       $request
     * @param SaleStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectStore(Request $request, ProjectStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_repository = new ProjectRepository();
        $project_repository->save($form->project_entity);
        return response()->json($data, 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectDelete($id, Request $request, ProjectDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_repository = new ProjectRepository();
        $project_repository->delete($id);
        return response()->json($data, 200);
    }

}