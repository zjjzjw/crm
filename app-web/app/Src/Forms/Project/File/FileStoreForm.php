<?php

namespace Huifang\Web\Src\Forms\Project\File;

use Huifang\Src\Project\Domain\Model\ProjectEntity;
use Huifang\Src\Project\Domain\Model\ProjectFileEntity;
use Huifang\Src\Project\Infra\Repository\ProjectFileRepository;
use Huifang\Src\Project\Infra\Repository\ProjectRepository;
use Huifang\Web\Src\Forms\Form;

class FileStoreForm extends Form
{

    /**
     * @var ProjectFileEntity
     */
    public $project_file_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                   => 'required|integer',
            'project_id'           => 'required|integer',
            'history_brands'       => 'required|string',
            'file_model'           => 'required|array',
            'price'                => 'required|array',
            'cooperation_brands'   => 'required|string',
            'project_file_comment' => 'required|array',
            'bench_brands'         => 'required|string',
        ];
    }


    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute是整型',
            'string'      => ':attribute是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'id'                   => '主键',
            'project_id'           => '项目ID',
            'history_brands'       => '历史参与品牌',
            'file_model'           => '型号',
            'price'                => '价格',
            'cooperation_brands'   => '合作品牌',
            'project_file_comment' => '评价',
            'bench_brands'         => '楼盘对标品牌',
        ];
    }

    public function validation()
    {
        if (!empty(array_get($this->data, 'id'))) {
            $project_file_repository = new ProjectFileRepository();
            $project_file_entity = $project_file_repository->fetch(array_get($this->data, 'id'));
        } else {
            $project_file_entity = new ProjectFileEntity();
        }
        $file_models = array_get($this->data, 'file_model');
        $prices = array_get($this->data, 'price');
        $project_file_info = [];
        foreach ($file_models as $key => $value) {
            if ($value && $prices[$key]) {
                $project_file_info[$key]['file_model'] = $value;
                $project_file_info[$key]['price'] = $prices[$key];
            }
        }

        $project_file_entity->project_id = array_get($this->data, 'project_id');
        $project_file_entity->history_brands = array_get($this->data, 'history_brands');
        $project_file_entity->cooperation_brands = array_get($this->data, 'cooperation_brands');
        $project_file_entity->project_file_comment = array_get($this->data, 'project_file_comment');
        $project_file_entity->tender_reason = array_get($this->data, 'tender_reason', '');//本次招标原因默认为空
        $project_file_entity->bench_brands = array_get($this->data, 'bench_brands');
        $project_file_entity->project_file_info = $project_file_info;
        $this->validateProjectFileEdit();
        $this->project_file_entity = $project_file_entity;
    }

    /**
     * 项目档案的编辑权限判断
     */
    public function validateProjectFileEdit()
    {
        $project_id = array_get($this->data, 'project_id');
        $project_repository = new ProjectRepository();
        /** @var ProjectEntity $project_entity */
        $project_entity = $project_repository->fetch($project_id);
        if (isset($project_entity) && $project_entity->user_id != request()->user()->id) {
            $this->addError('permission', '权限不足！');
        }
    }

}