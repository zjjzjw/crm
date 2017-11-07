<?php

namespace Huifang\Service\Card;

use Huifang\Src\Card\Domain\Model\CardEntity;
use Huifang\Src\Card\Infra\Repository\CardRepository;

class CardService
{

    public function getCardList($user_id, $keyword = '')
    {
        $data = [];
        $cards = [];
        $card_repository = new CardRepository();
        $card_entities = $card_repository->getCardsByUserId($user_id);
        /** @var CardEntity $card_entity */
        foreach ($card_entities as $card_entity) {
            $cards[] = $card_entity->toArray();
        }
        $alphas = $this->getAlphas();
        foreach ($alphas as $alpha) {
            $item = [];
            $item['name'] = $alpha;
            $item['cards'] = collect($cards)->where('initials', $alpha)->toArray();
            $data[] = $item;
        }
        return $data;
    }


    public function getCardListByKeyword($user_id, $keyword, $limit = 20)
    {
        $items = [];
        $card_repository = new CardRepository();
        $card_entities = $card_repository->getCardsByUserId($user_id, $keyword);
        foreach ($card_entities as $card_entity) {
            $item = $card_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }


    public function getAlphas()
    {
        return [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'k', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ];
    }

    public function getCardInfo($id)
    {
        $data = [];
        $card_repository = new CardRepository();
        /** @var CardEntity $card_entity */
        $card_entity = $card_repository->fetch($id);
        if (isset($card_entity)) {
            $data = $card_entity->toArray();
        }

        return $data;

    }


}

