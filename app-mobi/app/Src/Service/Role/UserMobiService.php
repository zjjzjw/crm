<?php namespace Huifang\Mobi\Src\Service\Role;


use Huifang\Service\Role\UserService;

class UserMobiService
{
    /**
     * 得到管辖范围的用户
     * 与getAssignUsers比少了部门的详细数据
     * @param int $company_id
     * @param int $user_id
     * @return array
     */
    public function getSearchUsers($company_id, $user_id)
    {
        $items = [];
        $user_service = new UserService();
        $users = $user_service->getSearchUsers($company_id, $user_id);
        foreach ($users as $user) {
            $item['id'] = $user['id'];
            $item['name'] = $user['name'];
            $items[] = $item;
        }
        return $items;
    }
}
