<?php

namespace Huifang\Service\Company;

use Carbon\Carbon;
use Huifang\Src\Company\Domain\Model\CompanyEntity;
use Huifang\Src\Company\Domain\Model\CompanySpecification;
use Huifang\Src\Project\Domain\Model\ProjectStepType;
use Huifang\Src\Sale\Domain\Model\SaleEntity;
use Huifang\Src\Sale\Domain\Model\SaleSpecification;
use Huifang\Src\Company\Infra\Repository\CompanyRepository;
use Huifang\Src\Sale\Infra\Repository\SaleRepository;
use Huifang\Src\Surport\Infra\Repository\CityRepository;
use Huifang\Src\Surport\Infra\Repository\ProvinceRepository;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyService
{
    /**
     * @param CompanySpecification $spec
     * @param int                  $per_page
     * @return array
     */
    public function getCompanyList(CompanySpecification $spec, $per_page)
    {
        $data = [];
        $company_repository = new CompanyRepository();
        $paginate = $company_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var CompanyEntity        $company_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $company_entity) {
            $item = $company_entity->toArray();
            $item['start_time'] = Carbon::parse($company_entity->start_time)->format('Y年m月d日');
            $item['end_time'] = Carbon::parse($company_entity->end_time)->format('Y年m月d日');
            $paginate[$key] = $item;
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    public function getCompanyInfo($id)
    {
        $data = [];
        $company_repository = new CompanyRepository();
        /** @var CompanyEntity $company_entity */
        $company_entity = $company_repository->fetch($id);
        if (isset($company_entity)) {
            $data = $company_entity->toArray();
            $data['start_time'] = Carbon::parse($company_entity->start_time)->format('Y-m-d');
            $data['end_time'] = Carbon::parse($company_entity->end_time)->format('Y-m-d');
        }
        return $data;

    }


}

