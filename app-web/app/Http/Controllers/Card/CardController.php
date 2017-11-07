<?php namespace Huifang\Web\Http\Controllers\Card;

use Huifang\Service\Card\CardService;
use Huifang\Web\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CardController extends BaseController
{
    public function cardEdit(Request $request, $id)
    {
        $data = [];
        $this->title = '名片录入';
        $this->file_css = 'card.edit';
        $this->file_js = 'card.edit';

        $card_service = new CardService();
        $data = $card_service->getCardInfo($id);

        return $this->view('touch.card.edit', $data);
    }
}


