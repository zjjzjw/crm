<?php

namespace Huifang\Service\Project;

use Huifang\Src\Project\Domain\Model\CharacterType;
use Huifang\Src\Project\Domain\Model\CurrentRelatedType;
use Huifang\Src\Project\Domain\Model\FeedBackType;
use Huifang\Src\Project\Domain\Model\ProjectStructureEntity;
use Huifang\Src\Project\Domain\Model\StructureRoleType;
use Huifang\Src\Project\Domain\Model\SupportType;
use Huifang\Src\Project\Infra\Repository\ProjectStructureRepository;

class ProjectStructureService
{

    public function getProjectStructureInfo($id)
    {
        $data = [];
        $project_structure_repository = new ProjectStructureRepository();
        /** @var ProjectStructureEntity $project_structure_entity */
        $project_structure_entity = $project_structure_repository->fetch($id);

        if (isset($project_structure_entity)) {
            $data = $project_structure_entity->toArray();
            $structure_role_types = StructureRoleType::acceptableEnums();
            $data['structure_role_type_name'] = $structure_role_types[$project_structure_entity->structure_role_id] ?? '';
            $current_related_types = CurrentRelatedType::acceptableEnums();
            $data['current_related_type_name'] = $current_related_types[$project_structure_entity->current_related_id] ?? '';
            $feedback_types = FeedBackType::acceptableEnums();
            $data['feedback_name'] = $feedback_types[$project_structure_entity->feedback] ?? '无';
            $support_types = SupportType::acceptableEnums();
            $data['support_type_name'] = $support_types[$project_structure_entity->support_type] ?? '';
            $character_types = CharacterType::acceptableEnums();
            $character_ids = explode(';', $project_structure_entity->character);
            $data['character_ids'] = $character_ids;
            $character_names = [];
            foreach ($character_ids as $character_id) {
                if (isset($character_types[$character_id])) {
                    $character_names[] = $character_types[$character_id];
                }
            }
            $data['character_names'] = $character_names;
        }
        return $data;
    }


    public function getProjectStructure($project_id, $type = 1)
    {
        $data = [];
        $project_structures = [];
        $project_structure_repository = new ProjectStructureRepository();
        $project_structure_entities = $project_structure_repository->getProjectStructureByProjectId($project_id, $type);
        foreach ($project_structure_entities as $project_structure_entity) {
            $project_structures[$project_structure_entity->id] = $project_structure_entity->toArray();
        }
        $data = $project_structures;

        return $data;
    }


}

