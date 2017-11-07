<?php

use Illuminate\Database\Seeder;
use Huifang\Src\Role\Infra\Eloquent\PermissionModel;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = $this->getData();
        foreach ($items as $item) {
            $permission_model = PermissionModel::find($item['id']);
            if (!isset($permission_model)) {
                $permission_model = new PermissionModel();
                $permission_model->id = $item['id'];
            }
            $permission_model->name = $item['name'];
            $permission_model->code = $item['code'];
            $permission_model->save();
        }
    }

    private function getData()
    {
        return [
            ['id' => 1, 'name' => '查看-销售线索', 'code' => '10001'],
            ['id' => 2, 'name' => '添加-销售线索', 'code' => '10002'],
            ['id' => 3, 'name' => '编辑-销售线索', 'code' => '10003'],
            ['id' => 4, 'name' => '认领-销售线索', 'code' => '10004'],
            ['id' => 5, 'name' => '分配-销售线索', 'code' => '10005'],
            ['id' => 6, 'name' => '查看-项目基本信息', 'code' => '10006'],
            ['id' => 7, 'name' => '添加-项目基本信息', 'code' => '10007'],
            ['id' => 8, 'name' => '编辑-项目基本信息', 'code' => '10008'],
            ['id' => 9, 'name' => '查看-项目档案', 'code' => '10009'],
            ['id' => 10, 'name' => '添加-项目档案', 'code' => '10010'],
            ['id' => 11, 'name' => '编辑-项目档案', 'code' => '10011'],
            ['id' => 12, 'name' => '查看-组织架构图', 'code' => '10012'],
            ['id' => 13, 'name' => '添加-组织架构图', 'code' => '10013'],
            ['id' => 14, 'name' => '编辑-组织架构图', 'code' => '10014'],
            ['id' => 15, 'name' => '查看-优劣势分析', 'code' => '10015'],
            ['id' => 16, 'name' => '添加-优劣势分析', 'code' => '10016'],
            ['id' => 17, 'name' => '编辑-优劣势分析', 'code' => '10017'],
            ['id' => 18, 'name' => '查看-采购流程', 'code' => '10018'],
            ['id' => 19, 'name' => '添加-采购流程', 'code' => '10019'],
            ['id' => 20, 'name' => '编辑-采购流程', 'code' => '10020'],
            ['id' => 21, 'name' => '查看-目标设置', 'code' => '10021'],
            ['id' => 22, 'name' => '添加-目标设置', 'code' => '10022'],
            ['id' => 23, 'name' => '编辑-目标设置', 'code' => '10023'],
            ['id' => 24, 'name' => '查看-目标障碍', 'code' => '10024'],
            ['id' => 25, 'name' => '添加-目标障碍', 'code' => '10025'],
            ['id' => 26, 'name' => '编辑-目标障碍', 'code' => '10026'],
            ['id' => 27, 'name' => '查看-客户信息', 'code' => '10027'],
            ['id' => 28, 'name' => '添加-客户信息', 'code' => '10028'],
            ['id' => 29, 'name' => '编辑-客户信息', 'code' => '10029'],
            ['id' => 30, 'name' => '查看-合同信息', 'code' => '10030'],
            ['id' => 31, 'name' => '添加-合同信息', 'code' => '10031'],
            ['id' => 32, 'name' => '编辑-合同信息', 'code' => '10032'],
            ['id' => 33, 'name' => '查看-名片信息', 'code' => '10033'],
            ['id' => 34, 'name' => '添加-名片信息', 'code' => '10034'],
            ['id' => 35, 'name' => '修改-名片信息', 'code' => '10035'],
            ['id' => 36, 'name' => '审核-销售线索', 'code' => '10036'],
            ['id' => 37, 'name' => '审核-目标障碍', 'code' => '10037'],
            ['id' => 38, 'name' => '合同-任务分配', 'code' => '10038'],
        ];
    }
}
