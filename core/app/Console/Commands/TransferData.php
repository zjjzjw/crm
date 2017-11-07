<?php

namespace Huifang\Console\Commands;

use Huifang\Jobs\SendReminderEmail;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileCommentModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileInfoModel;
use Huifang\Src\Project\Infra\Eloquent\ProjectFileModel;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleStatus;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Inspiring;

class TransferData extends BaseCommand
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:data';

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
        $project_file_models = ProjectFileModel::all();
        /** @var ProjectFileModel $project_file_model */
        foreach ($project_file_models as $project_file_model) {
            $project_file = $project_file_model->toArray();
            if ((int)$project_file['price'] || $project_file['file_model']) {
                $project_file_info_model = new ProjectFileInfoModel();
                $project_file_info_model->project_file_id = $project_file['id'];
                $project_file_info_model->file_model = $project_file['file_model'];
                $project_file_info_model->price = $project_file['price'];
                $project_file_info_model->save();
                $this->info('id：'.$project_file['id'].' 型号 价格导入完成');
            }

            if ($project_file['evaluate']) {
                $project_file_comment_model = new ProjectFileCommentModel();
                $project_file_comment_model->project_file_id = $project_file['id'];
                $project_file_comment_model->comment = $project_file['evaluate'];
                $project_file_comment_model->save();
                $this->info('id：'.$project_file['id'].' 评价导入完成');
            }
        }
        $this->comment('导入完成！');
    }
}
