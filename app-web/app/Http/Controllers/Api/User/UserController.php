<?php namespace Huifang\Web\Http\Controllers\Api\User;

use Huifang\Service\Contract\SignTaskService;
use Huifang\Service\Project\ProjectAimService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Sale\SaleService;
use Huifang\Src\Contract\Infra\Repository\SignTaskRepository;
use Huifang\Src\Role\Infra\Repository\UserFeedbackRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Contract\SignTaskStoreForm;
use Huifang\Web\Src\Forms\Project\Aim\AimHinderSearchForm;
use Huifang\Web\Src\Forms\Sale\SaleSearchForm;
use Huifang\Web\Src\Forms\User\ModifyPasswordForm;
use Huifang\Web\Src\Forms\User\UserFeedbackStoreForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends BaseController
{
    /**
     * 密码修改接口
     * @param Request            $request
     * @param ModifyPasswordForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function modifyPassword(Request $request, ModifyPasswordForm $form)
    {
        $data = [];
        $form->validate($request->all());

        $user = $this->getUser();
        $user->password = md5(md5($form->new_password) . config('auth.salt'));
        $user->save();
        Auth::logout();
        return response()->json($data, 200);
    }

    /**
     * 意见反馈保存接口
     * @param Request               $request
     * @param UserFeedbackStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeUserFeedback(Request $request, UserFeedbackStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $user_feedback_repository = new UserFeedbackRepository();
        $user_feedback_repository->save($form->user_feedback_entity);
        return response()->json($data, 200);
    }


    /**
     * 我的目标障碍审核列表
     * @param Request             $request
     * @param AimHinderSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvalHinders(Request $request, AimHinderSearchForm $form)
    {
        $data = [];

        $project_aim_service = new ProjectAimService();
        $user = $this->getUser();

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);

        //自己管理的数据
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user->id;

        $request->merge(['user_ids' => $user_ids]);

        $form->validate($request->all());
        $data = $project_aim_service->getApprovalAimHinders($form);

        return response()->json($data, 200);
    }

    /**
     * 我的销售列表审核
     * @param Request        $request
     * @param SaleSearchForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvalSales(Request $request, SaleSearchForm $form)
    {
        $data = [];
        $user = $this->getUser();

        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);

        //自己管理的数据
        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);

        $form->validate($request->all());

        $sale_service = new SaleService();

        $data = $sale_service->getApprovalSaleList($form->sale_specification, 10);

        return response()->json($data, 200);
    }

    /**
     * @param Request           $request
     * @param SignTaskStoreForm $form
     */
    public function storeSignTask(Request $request, SignTaskStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $sign_task_repository = new SignTaskRepository();
        $sign_task_repository->save($form->sign_task_entity);

        return response()->json($data, 200);
    }

}



