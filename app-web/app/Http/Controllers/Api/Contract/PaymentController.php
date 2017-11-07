<?php namespace Huifang\Web\Http\Controllers\Api\Contract;

use Huifang\Src\Contract\Domain\Model\ContractPaymentEntity;
use Huifang\Src\Contract\Infra\Repository\ContractPaymentRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Contract\Payment\PaymentDeleteForm;
use Huifang\Web\Src\Forms\Contract\Payment\PaymentStoreForm;
use Illuminate\Http\Request;


class PaymentController extends BaseController
{
    public function contractPaymentStore(Request $request, PaymentStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $contract_payment_repository = new ContractPaymentRepository();
        $contract_payment_repository->save($form->contract_payment_entity);
        $contract_payment_repository->calculatorPaymentStatus(
            $form->contract_payment_entity->contract_id,
            $form->contract_payment_entity->period
        );
        return response()->json($data, 200);

    }

    public function contractPaymentDelete(Request $request, $id, PaymentDeleteForm $form)
    {
        $data = [];
        $request->merge(['id' => $id]);
        $form->validate($request->all());

        $contract_payment_repository = new ContractPaymentRepository();
        /** @var ContractPaymentEntity $contract_payment_entity */
        $contract_payment_entity = $contract_payment_repository->fetch($id);
        if (isset($contract_payment_entity)) {
            $contract_payment_repository->delete($id);
            $contract_payment_repository->calculatorPaymentStatus(
                $contract_payment_entity->contract_id,
                $contract_payment_entity->period
            );
        }
        return response()->json($data, 200);
    }
}