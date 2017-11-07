<?php namespace Huifang\Web\Http\Controllers\Customer;

use Huifang\Service\Customer\CustomerService;
use Huifang\Service\Project\ProjectStructureService;
use Huifang\Service\Role\UserService;
use Huifang\Service\Surport\ProvinceService;
use Huifang\Src\Customer\Domain\Model\BuildProjectCountType;
use Huifang\Src\Customer\Domain\Model\CustomerLevelType;
use Huifang\Src\Customer\Domain\Model\CustomerSpecification;
use Huifang\Src\Customer\Domain\Model\FuturePotentialType;
use Huifang\Src\Customer\Domain\Model\ProjectCountType;
use Huifang\Src\Project\Domain\Model\CharacterType;
use Huifang\Src\Project\Domain\Model\CurrentRelatedType;
use Huifang\Src\Project\Domain\Model\FeedBackType;
use Huifang\Src\Project\Domain\Model\StructureRoleType;
use Huifang\Src\Project\Domain\Model\StructureType;
use Huifang\Src\Project\Domain\Model\SupportType;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Customer\CustomerSearchForm;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    /**
     * 客户列表
     * @param Request $request
     * @return \View
     */
    public function customerList(Request $request, CustomerSearchForm $form)
    {
        $data = [];
        $this->title = '全部客户';
        $this->file_css = 'customer.list';
        $this->file_js = 'customer.list';
        $user = $this->getUser();
        //全部客户列表
        $user_service = new UserService();
        $search_users = $user_service->getSearchUsers($user->company->id, $user->id);

        $user_ids = [];
        foreach ($search_users as $search_user) {
            $user_ids[] = $search_user['id'];
        }
        //加入自己
        $user_ids[] = $user->id;
        $request->merge(['user_ids' => $user_ids]);
        $request->merge(['company_id' => $user->company_id]);

        $data = $this->getDataList($request, $form);

        $data['search_users'] = $search_users;
        $data['route_name'] = 'customer.list';

        return $this->view('touch.customer.list', $data);
    }

    /**
     * 我的客户列表
     * @return \View
     */
    public function customerIndividualList(Request $request, CustomerSearchForm $form)
    {
        $data = [];
        $this->title = '我的客户';
        $this->file_css = 'customer.list';
        $this->file_js = 'customer.list';
        //我的客户列表
        $user = $this->getUser();
        $request->merge(['user_id' => $user->id]);
        $request->merge(['company_id' => $user->company_id]);

        $data = $this->getDataList($request, $form);
        $data['route_name'] = 'customer.individual.list';
        return $this->view('touch.customer.list', $data);
    }


    protected function getDataList(Request $request, CustomerSearchForm $form)
    {

        $per_page = $request->get('per_page', 10);

        $form->validate($request->all());
        $customer_service = new CustomerService();

        $data = $customer_service->getTouchCustomerList($form->customer_specification);

        //城市
        $province_service = new ProvinceService();
        $provinces = $province_service->getProvinceForCustomer();
        $data['provinces'] = $provinces;

        $project_count_types = ProjectCountType::acceptableEnums();
        $data['project_count_types'] = $project_count_types;

        $build_project_count_types = BuildProjectCountType::acceptableEnums();
        $data['build_project_count_types'] = $build_project_count_types;

        $future_potential_types = FuturePotentialType::acceptableEnums();
        $data['future_potential_types'] = $future_potential_types;


        $appends = $this->getPageAppends($form->customer_specification);
        //ajax 分页需要
        $appends['per_page'] = $per_page;
        $appends['page'] = $data['page']['current_page'] ?? 1;

        $data['appends'] = $appends;

        $choose = [
            'title'        => $this->title,
            'url'          => route('customer.edit', ['id' => 0]),
            'choose_items' => [
                [
                    'url'  => route('customer.list'),
                    'name' => '全部客户',
                ],
                [
                    'url'  => route('customer.individual.list'),
                    'name' => '我的客户',
                ],
            ],
        ];
        $data['choose'] = $choose;
        return $data;

    }

    /**
     * 项目详情
     * @param $id
     * @return \View
     */
    public function customerDetail($id)
    {
        $data = [];
        $this->title = '客户详情';
        $this->file_css = 'customer.detail';
        $this->file_js = 'customer.detail';

        $customer_service = new CustomerService();
        $data = $customer_service->getCustomerInfo($id);

        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForCustomer();

        return $this->view('touch.customer.detail', $data);
    }

    /**
     * 项目添加、修改
     * @param Request $request
     * @param         $id
     * @return \View
     */
    public function customerEdit(Request $request, $id)
    {
        $data = [];
        $this->file_css = 'customer.edit';
        $this->file_js = 'customer.edit';
        if (!empty($id)) {
            $this->title = '编辑客户';
        } else {
            $this->title = '创建客户';
        }

        $customer_service = new CustomerService();
        $data = $customer_service->getCustomerInfo($id);

        $province_service = new ProvinceService();
        $data['areas'] = $province_service->getProvinceForCustomer();

        $customer_level_types = CustomerLevelType::acceptableEnums();

        $data['customer_level_types'] = $customer_level_types;

        return $this->view('touch.customer.edit', $data);
    }


    //组织架构
    public function structure($customer_id)
    {
        $data = [];
        $this->file_css = 'customer.structure.flow';
        $this->file_js = 'customer.structure.flow';
        $this->title = '组织架构';

        $project_structure_service = new ProjectStructureService();
        $structure = $project_structure_service->getProjectStructure($customer_id, StructureType::TYPE_CUSTOMER);
        $structure = $this->getTree($structure);
        $data['structure'] = $structure;
        $html = '';
        if (!empty($structure)) {
            $data['html'] = $this->getTreeHtml(current($structure), $html);
        }
        $data['customer_id'] = $customer_id;

        return $this->view('touch.customer.structure.flow', $data);
    }

    public function structureDetail($customer_id, $id)
    {
        $this->file_css = 'customer.structure.detail';
        $this->file_js = 'customer.structure.detail';
        $this->title = '组织架构详情';

        if (!empty($id)) {
            $project_structure_service = new ProjectStructureService();
            $data = $project_structure_service->getProjectStructureInfo($id);
        }
        $structure_role_types = StructureRoleType::acceptableEnums();
        $data['structure_role_types'] = $structure_role_types;
        $current_related_types = CurrentRelatedType::acceptableEnums();
        $data['current_related_types'] = $current_related_types;
        $feedback_types = FeedBackType::acceptableEnums();
        $data['feedback_types'] = $feedback_types;

        $data['customer_id'] = $customer_id;

        return $this->view('touch.customer.structure.detail', $data);
    }


    public function structureEdit($customer_id, $parent_id, $id)
    {
        $data = [];
        $this->file_css = 'customer.structure.edit';
        $this->file_js = 'customer.structure.edit';
        $this->title = '组织架构';
        if (!empty($id)) {
            $project_structure_service = new ProjectStructureService();
            $data = $project_structure_service->getProjectStructureInfo($id);
        } else {
            $data['structure_type'] = StructureType::TYPE_CUSTOMER;
        }
        $structure_role_types = StructureRoleType::acceptableEnums();
        $data['structure_role_types'] = $structure_role_types;
        $current_related_types = CurrentRelatedType::acceptableEnums();
        $data['current_related_types'] = $current_related_types;
        $support_types = SupportType::acceptableEnums();
        $data['support_types'] = $support_types;
        $character_types = CharacterType::acceptableEnums();
        $data['character_types'] = $character_types;

        $feedback_types = FeedBackType::acceptableEnums();
        $data['feedback_types'] = $feedback_types;

        $data['id'] = $id;
        $data['parent_id'] = $parent_id;
        $data['customer_id'] = $customer_id;

        return $this->view('touch.customer.structure.edit', $data);
    }


    /**
     * @param CustomerSpecification $spec
     * @return array
     */
    protected function getPageAppends(CustomerSpecification $spec)
    {
        $appends = [];

        if ($spec->city_id) {
            $appends['city_id'] = $spec->city_id;
        }
        if ($spec->province_id) {
            $appends['province_id'] = $spec->province_id;
        }

        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }

        if ($spec->select_user_id) {
            $appends['select_user_id'] = $spec->select_user_id;
        }

        if ($spec->build_project_count_type) {
            $appends['build_project_count_type'] = $spec->build_project_count_type;
        }

        if ($spec->project_count_type) {
            $appends['project_count_type'] = $spec->project_count_type;
        }

        if ($spec->future_potential_type) {
            $appends['future_potential_type'] = $spec->future_potential_type;
        }

        if ($spec->column) {
            $appends['column'] = $spec->column;
        } else {
            $appends['column'] = 'created_at';
        }

        if ($spec->sort) {
            $appends['sort'] = $spec->sort;
        } else {
            $appends['sort'] = 'desc';
        }
        return $appends;
    }

    protected function getTree($items)
    {
        $tree = array();
        foreach ($items as $item) {
            if (isset($items[$item['parent_id']])) {
                $items[$item['parent_id']]['nodes'][] = &$items[$item['id']];
            } else {
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    protected function getTreeHtml($tree, &$html)
    {
        $bg_color = 'grey-bg';
        switch ($tree['structure_role_id']) {
            case StructureRoleType::STAKEHOLDER:
                $bg_color = "blue-bg";
                break;
            case StructureRoleType::KEY_PERSON:
                $bg_color = "red-bg";
                break;
            case StructureRoleType::NON_STAKEHOLDER:
                $bg_color = "grey-bg";
                break;
            default:
                break;
        }

        //得到支持和反对
        $support_types = SupportType::acceptableEnums();
        $support_type_name = $support_types[$tree['support_type']] or '';
        $html .= <<< DOC
                <li class="{$bg_color}">{$tree['position_name']}：{$tree['name']}
                <p class="relation">
                   {$this->getStars($tree['current_related_id'])}
                </p>
                    <div class="func-btn" data-id="{$tree['id']}" data-parent-id="{$tree['parent_id']}">
                       <i class="iconfont">&#xe61f;</i>
                       <i class="iconfont">&#xe60e;</i>
                       <i class="iconfont">&#xe603;</i>
                    </div>
                <p class="suport">{$support_type_name}</p>
DOC;

        if (isset($tree['nodes'])) {
            $html .= '<ul>';
            foreach ($tree['nodes'] as $next_tree) {
                $this->getTreeHtml($next_tree, $html);
            }
            $html .= '</ul>';
        }
        $html .= <<< DOC
                </li>
DOC;
        return $html;
    }

    protected function getStars($num)
    {
        $html = '';
        for ($i = 1; $i <= 4; $i++) {
            if ($i < $num) {
                $html .= '<i class="iconfont active">&#xe676;</i>';
            } else {
                $html .= '<i class="iconfont">&#xe676;</i>';
            }
        }
        return $html;
    }


}