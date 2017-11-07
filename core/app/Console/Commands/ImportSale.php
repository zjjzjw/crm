<?php

namespace Huifang\Console\Commands;

use Huifang\Jobs\SendReminderEmail;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Inspiring;

class ImportSale extends BaseCommand
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = __DIR__;
        $sale_repository = new SaleRepository();
        $file_path = $path . '/Data/sale.txt';
        if (file_exists($file_path)) {
            $fp = fopen($file_path, "r");
            $str = "";
            while (!feof($fp)) {
                $str = fgets($fp);//逐行读取。如果fgets不写length参数，默认是读取1k。
                $str = str_replace("\n", "", $str);
                $row = explode('&', $str);
                //这里是判断，如果重复就不导入
                $sale_entity = $sale_repository->getSaleByProjectNameAndAddress(2, $row[0], $row[3]);
                if (!isset($sale_entity)) {
                    $sale_entity = new SaleEntity();
                    $sale_entity->user_id = $row[7];
                    $sale_entity->company_id = 2;
                    $sale_entity->project_name = $row[0];
                    $sale_entity->province_id = $row[1];
                    $sale_entity->city_id = $row[2];
                    $sale_entity->address = $row[3];
                    $sale_entity->developer_name = $row[4];
                    $sale_entity->developer_group_name = $row[5];
                    $sale_entity->project_volume = $row[6];
                    $sale_entity->project_step_id = 0;
                    $sale_entity->contact_name = '无';
                    $sale_entity->position_name = '无';
                    $sale_entity->contact_phone = '无';
                    $sale_entity->close_reason = '';
                    $sale_entity->created_user_id = 1;
                    $sale_entity->status = SaleStatus::ASSIGNED;
                    $sale_entity->close_status = 0;
                    $sale_repository->save($sale_entity);
                }
                $this->info($sale_entity->project_name);
            }

        }
        $this->comment('导入完成！');
    }
}
