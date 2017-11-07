<?php namespace Huifang\Crm\Http\Controllers;


use Huifang\Crm\Src\Forms\Company\Role\UserFeedbackSearchForm;
use Huifang\Service\Role\UserFeedbackService;
use Huifang\Src\Role\Domain\Model\UserFeedbackSpecification;
use Illuminate\Http\Request;

class SuggestionController extends BaseController
{
    public function index(Request $request, UserFeedbackSearchForm $form)
    {
        $data = [];
        $this->title = '意见反馈';
        $this->file_css = 'pages.suggestion.index';
        $this->file_js = 'pages.suggestion.index';
        $form->validate($request->all());
        $user_feedback_service = new UserFeedbackService();
        $data = $user_feedback_service->getUserFeedbackList($form->user_feedback_specification, 20);
        $appends = $this->getPageAppends($form->user_feedback_specification);
        $data['appends'] = $appends;


        return $this->view('pages.suggestion.index', $data);
    }


    public function edit()
    {
        $this->file_css = 'pages.suggestion.edit';
        $this->file_js = 'pages.suggestion.edit';
        $data = [];

        return $this->view('pages.suggestion.edit', $data);
    }

    /**
     * @param UserFeedbackSpecification $spec
     */
    public function getPageAppends(UserFeedbackSpecification $spec)
    {
        $appends = [];
        if ($spec->start_time) {
            $appends['start_time'] = $spec->start_time->toDateString();
        }
        if ($spec->end_time) {
            $appends['end_time'] = $spec->end_time->toDateString();
        }
        if ($spec->keyword) {
            $appends['keyword'] = $spec->keyword;
        }
        return $appends;
    }

}