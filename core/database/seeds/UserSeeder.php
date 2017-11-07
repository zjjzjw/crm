<?php

use Illuminate\Database\Seeder;
use Huifang\Src\Role\Infra\Eloquent\UserModel;

class UserSeeder extends Seeder
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
            $user_model = UserModel::find($item['id']);
            if (!isset($user_model)) {
                $user_model = new UserModel();
                $user_model->id = $item['id'];
            }
            $user_model->company_id = $item['company_id'];
            $user_model->name = $item['name'];
            $user_model->email = $item['email'];
            $user_model->phone = $item['phone'];
            $user_model->password = $item['password'];
            $user_model->save();
        }
    }

    private function getData()
    {
        return [
            [
                'id'         => 1,
                'company_id' => 1,
                'name'       => '孙红玉',
                'email'      => 'cgahshy@126.com',
                'phone'      => '13816958237',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 2,
                'company_id' => 1,
                'name'       => '林宫兵',
                'email'      => '2282538484@qq.com',
                'phone'      => '17135501105',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 3,
                'company_id' => 1,
                'name'       => '王晓北',
                'email'      => '1686692766@qq.com',
                'phone'      => '17135502300',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 4,
                'company_id' => 1,
                'name'       => '郭庆',
                'email'      => '1149921221@qq.com',
                'phone'      => '17135501101',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 5,
                'company_id' => 1,
                'name'       => '魏杰',
                'email'      => '125680613@qq.com',
                'phone'      => '18516129033',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 6,
                'company_id' => 1,
                'name'       => '王胜',
                'email'      => 'sheng.wang@fq960.com',
                'phone'      => '18221188368',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 7,
                'company_id' => 1,
                'name'       => '姜立祥',
                'email'      => 'lixiang.jiang@fq960.com',
                'phone'      => '13761577991',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 8,
                'company_id' => 1,
                'name'       => '沈丽华',
                'email'      => 'lh.shen@fq960.com',
                'phone'      => '17701686258',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 9,
                'company_id' => 1,
                'name'       => '刘恒伟',
                'email'      => 'hw.liu@fq960.com',
                'phone'      => '13105279055',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 10,
                'company_id' => 1,
                'name'       => '尤娅',
                'email'      => 'ya.you@fq960.com',
                'phone'      => '13764906484',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 11,
                'company_id' => 1,
                'name'       => '陈博',
                'email'      => 'bo.chen@fq960.com',
                'phone'      => '18739931611',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 12,
                'company_id' => 1,
                'name'       => '王诗咏',
                'email'      => 'shiyong.wang@fq960.com',
                'phone'      => '15038319279',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 13,
                'company_id' => 1,
                'name'       => '林森',
                'email'      => 'sen.lin@fq960.com',
                'phone'      => '13916943367',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 14,
                'company_id' => 1,
                'name'       => '张子芊',
                'email'      => 'ziqian.zhang@fq960.com',
                'phone'      => '18352034903',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 15,
                'company_id' => 1,
                'name'       => '龙香菊',
                'email'      => 'xj.long@fq960.com',
                'phone'      => '13681687756',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 16,
                'company_id' => 1,
                'name'       => '项圣接',
                'email'      => 'rita.xiang@fq960.com',
                'phone'      => '15268540070',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 17,
                'company_id' => 1,
                'name'       => '苗斐',
                'email'      => 'fei.miao@fq960.com',
                'phone'      => '17717895166',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 19,
                'company_id' => 1,
                'name'       => '朱敏',
                'email'      => 'danny.zhu@fq960.com',
                'phone'      => '13774242488',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 20,
                'company_id' => 1,
                'name'       => '董搏谨',
                'email'      => 'bojin.dong@fq960.com',
                'phone'      => '18945051758',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 21,
                'company_id' => 1,
                'name'       => '钟启华',
                'email'      => 'qihua@fq960.com',
                'phone'      => '15000705987',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 22,
                'company_id' => 1,
                'name'       => '钱晨',
                'email'      => 'chen.qian@fq960.com',
                'phone'      => '15000705987',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 23,
                'company_id' => 1,
                'name'       => '杨哲',
                'email'      => 'zh.yang@fq960.com',
                'phone'      => '18801926202',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 24,
                'company_id' => 1,
                'name'       => '刘金花',
                'email'      => 'jh.liu@fq960.com',
                'phone'      => '18026204955',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 25,
                'company_id' => 1,
                'name'       => '王成',
                'email'      => 'mk.wang@fq960.com',
                'phone'      => '15800332085',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
            [
                'id'         => 26,
                'company_id' => 1,
                'name'       => '冯宇',
                'email'      => 'yu.feng@fq960.com',
                'phone'      => '18337136810',
                'password'   => '5f1d7a84db00d2fce00b31a7fc73224f',
            ],
        ];

    }

}
