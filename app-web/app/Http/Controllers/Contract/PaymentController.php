<?php namespace Huifang\Web\Http\Controllers\Contract;

use Huifang\Service\Contract\ContractPaymentService;
use Huifang\Service\Contract\ContractService;
use Huifang\Src\Contract\Domain\Model\ContractPaymentType;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Service\Project\ProjectService;
use Illuminate\Http\Request;

//回款详情
class PaymentController extends BaseController
{
    public function paymentList($contract_id)
    {
        $this->title = '回款详情';
        $this->file_css = 'contract.payment.list';
        $this->file_js = 'contract.payment.list';

        $contract_service = new ContractService();
        $data = $contract_service->getContractInfo($contract_id);
        //得到列表数据
        $contract_payment_service = new ContractPaymentService();
        $periods = $contract_payment_service->getContractPaymentList($contract_id);
        $has_payment_amount = $contract_payment_service->getHasPaymentAmount($contract_id);
        $data['periods'] = $periods;
        $data['has_payment_amount'] = $has_payment_amount;
        $percent = 0;
        if (!empty($data['contract_amount'])) {
            $percent = intval(($data['has_payment_amount'] / $data['contract_amount']) * 100);
        }
        $data['percent'] = $percent;
        $data['contract_id'] = $contract_id;
        return $this->view('touch.contract.payment.list', $data);
    }

    //详情页
    public function paymentDetail(Request $request, $contract_id, $id)
    {
        $data = [];
        $this->file_css = 'contract.payment.detail';
        $this->file_js = 'contract.payment.detail';
        $this->title = '回款计划详情';

        $contract_payment_service = new ContractPaymentService();
        $data = $contract_payment_service->getContractPaymentInfo($id);
        if ($data['payment_type'] == ContractPaymentType::TYPE_RECORD) {
            $this->title = '回款记录详情';
        }
        $data['contract_id'] = $contract_id;
        $data['id'] = $id;

        return $this->view('touch.contract.payment.detail', $data);
    }

    //编辑
    public function paymentEdit(Request $request, $contract_id, $type, $id)
    {
        $data = [];
        $this->file_css = 'contract.payment.edit';
        $this->file_js = 'contract.payment.edit';
        $this->title = '编辑回款计划';
        $user = $this->getUser();
        $action_name = '添加';
        if (!empty($id)) {
            $action_name = '编辑';
        }
        $title_name = '回款计划';
        if ($type == ContractPaymentType::TYPE_RECORD) {
            $title_name = '回款记录';
        }
        $this->title = $action_name . $title_name;
        $contract_payment_service = new ContractPaymentService();
        if (!empty($id)) {
            $data = $contract_payment_service->getContractPaymentInfo($id);
        }
        $periods = $contract_payment_service->getPeriodList();
        $data['periods'] = $periods;
        $contract_payment_types = ContractPaymentType::acceptableEnums();
        $title_name = $contract_payment_types[$type] ?? '';
        $data['title_name'] = $title_name;
        $data['contract_id'] = $contract_id;
        $data['type'] = $type;
        $data['id'] = $id;

        return $this->view('touch.contract.payment.edit', $data);
    }

}