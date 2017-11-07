<?php namespace Huifang\Web\Http\Controllers\Help;

use Huifang\Web\Http\Controllers\BaseController;

class HelpController extends BaseController
{
    public function helpList()
    {
        $this->title = '帮助中心';
        $this->file_css = 'help.list';
        return $this->view('touch.help.list');
    }

    //销售线索
    public function helpSalesDetail($type)
    {
        $this->title = '帮助中心';
        $this->file_css = 'help.detail';
        $data = [];
        $data['type'] = $type;

        return $this->view('touch.help.sales.detail', $data);
    }

    //合同管理
    public function helpCustomerDetail($type)
    {
        $this->title = '帮助中心';
        $this->file_css = 'help.detail';
        $data = [];
        $data['type'] = $type;

        return $this->view('touch.help.customer.detail', $data);
    }

    //合同管理
    public function helpContractDetail($type)
    {
        $this->title = '帮助中心';
        $this->file_css = 'help.detail';
        $data = [];
        $data['type'] = $type;

        return $this->view('touch.help.contract.detail', $data);
    }

    //项目管理
    public function helpProjectDetail($type)
    {
        $this->title = '帮助中心';
        $this->file_css = 'help.detail';
        $data = [];
        $data['type'] = $type;

        return $this->view('touch.help.project.detail', $data);
    }

    //我
    public function helpUserDetail($type)
    {
        $this->title = '帮助中心';
        $this->file_css = 'help.detail';
        $data = [];
        $data['type'] = $type;

        return $this->view('touch.help.user.detail', $data);
    }
}