<?php namespace Huifang\Src\Msg\Domain\Interfaces;


use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Msg\Domain\Model\BroadcastMsgSpecification;

interface BroadcastMsgInterface extends Repository
{

    /**
     * @param BroadcastMsgSpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(BroadcastMsgSpecification $spec, $per_page = 10);
}