<?php namespace Xinfang\Listeners\Statistics;

use Xinfang\Domains\Statistics\Entities\BusinessType;
use Xinfang\Domains\Statistics\Entities\DepartmentType;
use Xinfang\Domains\Statistics\Repositories\BakDepartmentRepository;
use Xinfang\Domains\Statistics\Repositories\Models\BakBrokerModel;
use Xinfang\Domains\Statistics\Repositories\Models\BakDepartmentModel;
use Xinfang\Domains\Statistics\Services\BrokerOutResultDailyService;
use Xinfang\Domains\Statistics\Services\DepartmentOutResultDailyService;
use Xinfang\Events\Statistics\StatisticsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use \ThriftClient;
use Xinfang\Listeners\Traits\Queue;


class StatisticsListener implements ShouldQueue
{
    use Queue;

    public $broker_uid;
    public $business_type;
    public $date;
    public $flag;

    /**
     * @param StatisticsEvent $event
     * @return string
     */
    public function handle(StatisticsEvent $event)
    {
        $broker_uid = $event->broker_uid;
        $date = $event->date;
        $business_type = $event->business_type;
        $flag = $event->flag;
        $bak_broker_model_team = BakBrokerModel::where('date', $date)
            ->where('broker_id', $broker_uid)
            ->first();
        //顾问备份表里有没有这个顾问
        if (!isset($bak_broker_model_team)) {
            /** @var $department_service \Account\Service\Department\DepartmentServiceClient */
            $account_service = ThriftClient::with('Account.Service.Account.AccountService');
            $brokers = $account_service->show([$broker_uid]);

            $bak_department_model_center = BakDepartmentModel::where('date', $date)
                ->where('department_id', $brokers[$broker_uid]->department_id)
                ->first();
            //组织架构备份表里有没有这个部门
            if (!isset($bak_department_model_center)) {
                return "部门不存在，请更新组织架构！";
            }

            $parent_ids = app(BakDepartmentRepository::class)
                ->getParentIdByTeamId(
                    $bak_department_model_center['parent_id'],
                    $date
                );

            $bak_broker_model = new BakBrokerModel();
            $bak_broker_model->city_id = $brokers[$broker_uid]->city_id;
            $bak_broker_model->center_id = $parent_ids[0]['department_id'];
            $bak_broker_model->center_name = $parent_ids[0]['department_name'];
            $bak_broker_model->team_id = $bak_department_model_center['department_id'];
            $bak_broker_model->team_name = $bak_department_model_center['department_name'];
            $bak_broker_model->broker_id = $brokers[$broker_uid]->id;
            $bak_broker_model->broker_name = $brokers[$broker_uid]->name;
            $bak_broker_model->date = $date;
            $bak_broker_model->save();
        }

        if ($business_type == BusinessType::CUSTOMER_CHANGE) {
            $this->getCustomerChange($broker_uid, $flag, $date);
        } elseif ($business_type == BusinessType::VISIT_CHANGE) {
            $this->getVisitChange($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::MANAGER_LOOK) {
            $this->getManagerLook($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::MANAGER_VISIT) {
            $this->getManagerVisit($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::CALL_NUM) {
            $this->getCallNum($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::CALL_TIME) {
            $this->getCallTime($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::OUTBOUND_OPT) {
            $this->getOutboundOpt($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::PRIVATE_BUYER_CALL_COUNT) {
            $this->updatePrivateBuyerCallNum($broker_uid, $flag, $date);
        } else if ($business_type == BusinessType::BROKER_DEAL_COUNT) {
            $this->updateBrokerDealCount($broker_uid, $flag, $date);
        }
    }

    /**
     * 统计成交量
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function updateBrokerDealCount($broker_uid, $flag, $date)
    {
        if (isset($flag['job']) && $flag['job']) {
            if ($flag['broker']) {
                $broker_out_result_daily_service = new BrokerOutResultDailyService();
                $broker_out_result_daily_service->updateBrokerDealCount($broker_uid, $date);
            }
            if ($flag['team']) {
                $department_out_result_daily_service = new DepartmentOutResultDailyService();
                $department_out_result_daily_service->updateBrokerDealCount($broker_uid, $date, DepartmentType::TEAM_TYPE);
            }
            if ($flag['center']) {
                $department_out_result_daily_service = new DepartmentOutResultDailyService();
                $department_out_result_daily_service->updateBrokerDealCount($broker_uid, $date, DepartmentType::CENTER_TYPE);
            }
            if ($flag['city']) {
                $department_out_result_daily_service = new DepartmentOutResultDailyService();
                $department_out_result_daily_service->updateBrokerDealCount($broker_uid, $date, DepartmentType::CITY_TYPE);
            }
        }
    }

    /**
     * 私客电话量
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function updatePrivateBuyerCallNum($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyPrivateBuyerCallNum($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updatePrivateBuyerCallNum($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updatePrivateBuyerCallNum($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updatePrivateBuyerCallNum($broker_uid, $date, DepartmentType::CITY_TYPE);
        }

    }

    /**
     * 新增私客
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getCustomerChange($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyBuyerNum($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyBuyerNum($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyBuyerNum($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyBuyerNum($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 带看量
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getVisitChange($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyVisitNum($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyVisitNum($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyVisitNum($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyVisitNum($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 部经理陪看
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getManagerLook($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyManagerLook($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyManagerLook($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyManagerLook($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyManagerLook($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 部经理回访
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getManagerVisit($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyManagerVisit($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyManagerVisit($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyManagerVisit($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyManagerVisit($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 电话量
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getCallNum($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyCallNum($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyCallNum($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyCallNum($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyCallNum($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 通话时长
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getCallTime($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyCallTime($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyCallTime($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyCallTime($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyCallTime($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 外呼结果
     * @param $broker_uid
     * @param $flag
     * @param $date
     */
    public function getOutboundOpt($broker_uid, $flag, $date)
    {
        if ($flag['broker']) {
            $broker_out_result_daily_service = new BrokerOutResultDailyService();
            $broker_out_result_daily_service->updateBrokerDailyOutboundOpt($broker_uid, $date);
        }
        if ($flag['team']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyOutboundOpt($broker_uid, $date, DepartmentType::TEAM_TYPE);
        }
        if ($flag['center']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyOutboundOpt($broker_uid, $date, DepartmentType::CENTER_TYPE);
        }
        if ($flag['city']) {
            $department_out_result_daily_service = new DepartmentOutResultDailyService();
            $department_out_result_daily_service->updateDepartmentDailyOutboundOpt($broker_uid, $date, DepartmentType::CITY_TYPE);
        }
    }

    /**
     * 事件订阅
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(StatisticsEvent::class, StatisticsListener::class . '@handle');
    }
}
