<?php namespace Huifang\Web\Http\Controllers\Api\Project;

use Huifang\Src\Project\Domain\Model\AimHinderStatus;
use Huifang\Src\Project\Domain\Model\ProjectAimHinderEntity;
use Huifang\Src\Project\Infra\Repository\ProjectAimHinderRepository;
use Huifang\Src\Project\Infra\Repository\ProjectAimRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Project\Aim\AimDeleteForm;
use Huifang\Web\Src\Forms\Project\Aim\AimHinderDeleteForm;
use Huifang\Web\Src\Forms\Project\Aim\AimHinderStoreForm;
use Huifang\Web\Src\Forms\Project\Aim\AimStoreForm;
use Illuminate\Http\Request;


class AimController extends BaseController
{
    /**
     * @param Request      $request
     * @param AimStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectAimStore(Request $request, AimStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $project_aim_repository = new ProjectAimRepository();
        $project_aim_repository->save($form->project_aim_entity);
        return response()->json($data, 200);
    }

    /**
     * @param Request            $request
     * @param AimHinderStoreForm $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectAimHinderStore(Request $request, AimHinderStoreForm $form)
    {
        $data = [];
        $request->merge(['status' => AimHinderStatus::STATUS_INIT]);
        $form->validate($request->all());

        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        $project_aim_hinder_repository->save($form->project_aim_hinder_entity);
        return response()->json($data, 200);
    }

    /**
     *
     * @param Request $request
     */
    public function projectAimHinderAudit(Request $request)
    {
        $data = [];
        $id = $request->get('id');
        $status = $request->get('status');
        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        /** @var ProjectAimHinderEntity $project_aim_hinder_entity */
        $project_aim_hinder_entity = $project_aim_hinder_repository->fetch($id);
        $project_aim_hinder_entity->status = $status;
        $project_aim_hinder_repository->save($project_aim_hinder_entity);
        return response()->json($data, 200);
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectAimDelete($id, Request $request, AimDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_aim_repository = new ProjectAimRepository();
        $project_aim_repository->delete($id);

        return response()->json($data, 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectAimHinderDelete($id, Request $request, AimHinderDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $project_aim_hinder_repository = new ProjectAimHinderRepository();
        $project_aim_hinder_repository->delete($id);
        return response()->json($data, 200);
    }

}