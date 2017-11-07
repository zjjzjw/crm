<?php

use Illuminate\Database\Seeder;
use Huifang\Src\Surport\Infra\Eloquent\CountyModel;

class CountySeeder extends Seeder
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
            $county_model = CountyModel::find($item['id']);
            if (!isset($county_model)) {
                $county_model = new CountyModel();
                $county_model->id = $item['id'];
            }
            $county_model->name = $item['name'];
            $county_model->city_id = $item['city_id'];
            $county_model->lng = $item['lng'];
            $county_model->lat = $item['lat'];
            $county_model->save();
        }
    }

    private function getData()
    {
        return [
            ['id' => 1, 'city_id' => 63, 'name' => '黄浦区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 2, 'city_id' => 63, 'name' => '徐汇区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 3, 'city_id' => 63, 'name' => '长宁区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 4, 'city_id' => 63, 'name' => '静安区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 5, 'city_id' => 63, 'name' => '普陀区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 6, 'city_id' => 63, 'name' => '虹口区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 7, 'city_id' => 63, 'name' => '杨浦区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 8, 'city_id' => 63, 'name' => '闵行区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 9, 'city_id' => 63, 'name' => '宝山区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 10, 'city_id' => 63, 'name' => '嘉定区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 11, 'city_id' => 63, 'name' => '浦东新区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 12, 'city_id' => 63, 'name' => '金山区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 13, 'city_id' => 63, 'name' => '松江区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 14, 'city_id' => 63, 'name' => '青浦区', 'lng' => 00.0000, 'lat' => 00.0000],
            ['id' => 15, 'city_id' => 63, 'name' => '奉贤区', 'lng' => 00.0000, 'lat' => 00.0000],
        ];

    }

}
