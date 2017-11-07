<?php namespace Huifang\Web\Http\Controllers\Api\Card;

use Huifang\Service\Card\CardService;
use Huifang\Src\Card\Infra\Repository\CardRepository;
use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Src\Forms\Card\CardStoreForm;
use Illuminate\Http\Request;


class CardController extends BaseController
{
    public function storeCard(Request $request, CardStoreForm $form)
    {

        $data = [];
        $form->validate($request->all());
        $card_repository = new CardRepository();
        $card_repository->save($form->card_entity);

        return response()->json($data, 200);
    }


    public function deleteCard(Request $request, $id)
    {
        $data = [];
        $card_repository = new CardRepository();
        $card_repository->delete($id);

    }

    public function getCardsByKeyword(Request $request)
    {
        $data = [];
        $user = $this->getUser();
        $keyword = $request->get('keyword');
        if ($keyword) {
            $card_service = new CardService();
            $data = $card_service->getCardListByKeyword($user->id, $keyword, 20);
        }
        return response()->json($data, 200);
    }

}