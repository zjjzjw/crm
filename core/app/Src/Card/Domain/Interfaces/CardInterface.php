<?php namespace Huifang\Src\Card\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;

interface CardInterface extends Repository
{

    /**
     * @param int    $user_id
     * @param string $keyword
     * @param int    $limit
     * @return array|\Illuminate\Support\Collection
     */
    public function getCardsByUserId($user_id, $keyword = '', $limit = null);

    /**
     * @param int|array $id
     */
    public function delete($id);

}