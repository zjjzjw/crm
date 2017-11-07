<?php namespace Huifang\Web\Http\Controllers\project;

use Huifang\Service\Project\ProjectStructureService;
use Huifang\Src\Project\Domain\Model\CharacterType;
use Huifang\Src\Project\Domain\Model\CurrentRelatedType;
use Huifang\Src\Project\Domain\Model\FeedBackType;
use Huifang\Src\Project\Domain\Model\StructureRoleType;
use Huifang\Src\Project\Domain\Model\StructureType;
use Huifang\Src\Project\Domain\Model\SupportType;
use Huifang\Web\Http\Controllers\BaseController;
use Symfony\Component\VarDumper\Cloner\Stub;


class StructureController extends BaseController
{
    /**
     * @param int $id 项目的ID
     * @return \View
     */
    public function structure($id)
    {
        $data = [];
        $this->file_css = 'project.structure.flow';
        $this->file_js = 'project.structure.flow';
        $this->title = '组织架构';
        $project_structure_service = new ProjectStructureService();
        $structure = $project_structure_service->getProjectStructure($id, StructureType::TYPE_PROJECT);
        $structure = $this->getTree($structure);
        $data['structure'] = $structure;
        $html = '';
        if (!empty($structure)) {
            $data['html'] = $this->getTreeHtml(current($structure), $html);
        }
        $data['project_id'] = $id;

        return $this->view('touch.project.structure.flow', $data);
    }

    public function structureDetail($project_id, $id)
    {
        $this->file_css = 'project.structure.detail';
        $this->file_js = 'project.structure.detail';
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

        return $this->view('touch.project.structure.detail', $data);
    }

    public function structureEdit($project_id, $parent_id, $id)
    {
        $data = [];
        $this->file_css = 'project.structure.edit';
        $this->file_js = 'project.structure.edit';
        $this->title = '组织架构';
        if (!empty($id)) {
            $project_structure_service = new ProjectStructureService();
            $data = $project_structure_service->getProjectStructureInfo($id);
        } else {
            $data['structure_type'] = StructureType::TYPE_PROJECT;
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
        $data['project_id'] = $project_id;


        return $this->view('touch.project.structure.edit', $data);
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
        $support_types = SupportType::acceptableEnums();
        $support_type_name = $support_types[$tree['support_type']] ?? '';
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


