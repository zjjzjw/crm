<?php

use Illuminate\Database\Seeder;
use Huifang\Src\Company\Infra\Eloquent\CompanyModel;

class CompanySeeder extends Seeder
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
            $company_model = CompanyModel::find($item['id']);
            if (!isset($company_model)) {
                $company_model = new CompanyModel();
                $company_model->id = $item['id'];
            }
            $company_model->name = $item['name'];
            $company_model->start_time = $item['start_time'];
            $company_model->end_time = $item['end_time'];
            $company_model->user_number = $item['user_number'];
            $company_model->is_free = $item['is_free'];
            $company_model->created_user_id = $item['created_user_id'];
            $company_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'              => 1,
                'name'            => '上海绘房信息科技有限公司',
                'start_time'      => '2017-01-01',
                'end_time'        => '2018-01-01',
                'user_number'     => 1000,
                'is_free'         => 1,
                'created_user_id' => 1,
            ],
        ];
    }

}
