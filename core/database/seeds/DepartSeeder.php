<?php

use Illuminate\Database\Seeder;
use \Huifang\Src\Role\Infra\Eloquent\DepartModel;

class DepartSeeder extends Seeder
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
            $depart_model = DepartModel::find($item['id']);
            if (!isset($depart_model)) {
                $depart_model = new DepartModel();
                $depart_model->id = $item['id'];
            }
            $depart_model->company_id = $item['company_id'];
            $depart_model->parent_id = $item['parent_id'];
            $depart_model->name = $item['name'];
            $depart_model->desc = $item['desc'];
            $depart_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'         => 1,
                'company_id' => 1,
                'parent_id'  => 0,
                'name'       => '客服部',
                'desc'       => '客服部',
            ],
            [
                'id'         => 2,
                'company_id' => 1,
                'parent_id'  => 0,
                'name'       => '技术部',
                'desc'       => '技术部',
            ],
            [
                'id'         => 3,
                'company_id' => 1,
                'parent_id'  => 0,
                'name'       => '销售部',
                'desc'       => '销售部',
            ],
            [
                'id'         => 4,
                'company_id' => 1,
                'parent_id'  => 0,
                'name'       => '行政部',
                'desc'       => '行政部',
            ],
            [
                'id'         => 5,
                'company_id' => 1,
                'parent_id'  => 0,
                'name'       => 'HR部门',
                'desc'       => 'HR部门',
            ],
            [
                'id'         => 6,
                'company_id' => 1,
                'parent_id'  => 0,
                'name'       => '产品运营部',
                'desc'       => '产品运营部',
            ],

        ];
    }

}
