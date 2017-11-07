<?php namespace Xinfang\Listeners;

use Carbon\Carbon;
use Xinfang\Listeners\Traits\Queue;
use Xinfang\Events\Visit\VisitStat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xinfang\Domains\Buyer\Entities\BuyerEntity;
use Xinfang\Domains\Buyer\Services\BuyerService;
use Xinfang\Domains\Buyer\Entities\BuyerVisitEntity;
use Xinfang\Domains\Buyer\Entities\BuyerFollowupEntity;

class VisitListener
{
    use Queue;
    /**
     * @desc 客户阶段,带看次数,最后跟进时间
     *
     * @param  VisitEvent $event
     * @return void
     */
    public function stat(VisitStat $event)
    {
        $params = [];
        $params['buyer_id'] = $event->buyer_id;
        $params['broker_id'] = $event->broker_id;
        if (!empty($event->public_broker_ids)) {
            $params['broker_id'] = $event->public_broker_ids;
        }
        $params['type'] = BuyerFollowupEntity::TYPE_VISIT;

        /** @var BuyerService $buyer_service */
        $buyer_service = app(BuyerService::class);
        /** @var BuyerEntity $buyer_entity */
        $followups = $buyer_service->showBuyerFollowup($params);
        $visit_ids = [];
        foreach ($followups as $followup) {
            $visit_ids[] = $followup->getTargetId();
        }
        $params = [];
        $params['visit_id'] = $visit_ids;
        $params['status'] = BuyerVisitEntity::VISIT_STATUS_FINISH;
        /** @var BuyerEntity $buyer_entity */
        $visits = $buyer_service->getVisitByCondition($params);

        $count = [];
        $count['loupan_id'] = [];
        $count['loupan_count'] = $count['visit_count'] = 0;
        foreach ($visits as $visit) {
            $loupan_ids = explode(',', $visit->getLoupanId());
            $count['loupan_id'] = array_merge($count['loupan_id'], $loupan_ids);
            //计算带看楼盘次数(重复楼盘多次计数)
            $count['loupan_count'] = $count['loupan_count'] + count($loupan_ids);
            $count['visit_count'] = $count['visit_count'] + 1;
        }

        switch ($count['visit_count'])
        {
        case 0 :
            $section = BuyerEntity::SECTION_VISIT_NONE;
            break;
        case 1 :
            $section = BuyerEntity::SECTION_VISIT_FIRST;
            break;
        default :
            $section = BuyerEntity::SECTION_VISIT_MANY;
            break;
        }
        //复看优先级要比多看高
        if (count(array_unique($count['loupan_id'])) != $count['loupan_count']) {
            $section = BuyerEntity::SECTION_VISIT_REPEAT;
        }

        $params = [
            'section'   => $section,
            'visit_num' => $count['visit_count'],
        ];
        $buyer_service->updateBuyer(
            $event->broker_id,
            $event->buyer_id,
            $params
        );
    }

    /**
     * 事件订阅
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(VisitStat::class, VisitListener::class . '@stat');
    }
}
