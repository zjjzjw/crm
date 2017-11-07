<?php namespace Huifang\Src\Role\Domain\Interfaces;

use Huifang\Src\Foundation\Domain\Interfaces\Repository;
use Huifang\Src\Role\Domain\Model\UserFeedbackSpecification;
use Huifang\Src\Role\Domain\Model\UserSpecification;

interface UserFeedbackInterface extends Repository
{

    /**
     * @param UserFeedbackSpecification $spec
     * @param int                       $per_page
     * @return mixed
     */
    public function search(UserFeedbackSpecification $spec, $per_page);

}