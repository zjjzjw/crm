<?php namespace Huifang\Admin\Http\Controllers\Api\Company;


use Huifang\Admin\Http\Controllers\BaseController;
use Huifang\Admin\Src\Forms\Company\Depart\DepartDeleteForm;
use Huifang\Admin\Src\Forms\Company\Depart\DepartStoreForm;
use Huifang\Service\Role\UserDataService;
use Huifang\Src\Role\Domain\Model\DepartEntity;
use Huifang\Src\Role\Domain\Model\UserEntity;
use Huifang\Src\Role\Infra\Repository\DepartRepository;
use Huifang\Src\Role\Infra\Repository\UserRepository;
use Illuminate\Http\Request;

class DepartController extends BaseController
{
    public function getNextLevel(Request $request, $id)
    {
        $data = [];
        $user_id = $request->get('user_id') ?? 0;
        $user_data_ids = [];
        if ($user_id) {
            $user_data_service = new UserDataService();
            $user_data_ids = $user_data_service->getUserDataDepartIds($user_id);
        }
        if (!empty($id)) {
            $depart_repository = new DepartRepository();
            $depart_entities = $depart_repository->getDepartByParentId($id);
            /** @var DepartEntity $depart_entity */
            foreach ($depart_entities as $depart_entity) {
                $item = $depart_entity->toArray();
                $item['select'] = false;
                if (in_array($depart_entity->id, $user_data_ids)) {
                    $item['select'] = true;
                }
                $data[] = $item;
            }
        }
        return $data;
    }

    public function getNextDepart(Request $request, $id)
    {
        $data = [];
        $user_id = $request->get('user_id') ?? 0;
        $user_data_ids = [];
        if ($user_id) {
            $user_repository = new UserRepository();
            /** @var UserEntity $user_entity */
            $user_entity = $user_repository->fetch($user_id);
            if (isset($user_entity)) {
                $user_data_ids = $user_entity->depart_ids;
            }
        }
        if (!empty($id)) {
            $depart_repository = new DepartRepository();
            $depart_entities = $depart_repository->getDepartByParentId($id);
            /** @var DepartEntity $depart_entity */
            foreach ($depart_entities as $depart_entity) {
                $item = $depart_entity->toArray();
                $item['select'] = false;
                if (in_array($depart_entity->id, $user_data_ids)) {
                    $item['select'] = true;
                }
                $data[] = $item;
            }
        }
        return $data;
    }


    public function delete($id, Request $request, DepartDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());
        $depart_repository = new DepartRepository();
        $depart_repository->delete($id);
        return response()->json($data, 200);
    }


    public function store(Request $request, DepartStoreForm $form)
    {
        $form->validate($request->all());
        $depart_repository = new DepartRepository();
        $depart_repository->save($form->depart_entity);
        $data['id'] = $form->depart_entity->id;
        return response()->json($data, 200);
    }

    public function update(Request $request, DepartStoreForm $form, $id)
    {
        return $this->store($request, $form, $id);
    }
}
