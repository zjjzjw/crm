<?php

namespace Huifang\Service\Product;


use Huifang\Src\Product\Domain\Model\ProductCategoryEntity;
use Huifang\Src\Product\Domain\Model\ProductCategorySpecification;
use Huifang\Src\Product\Infra\Repository\ProductCategoryRepository;

class ProductCategoryService
{

    public function getProductCategoriesByCompanyId($company_id)
    {
        $product_categories = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoriesByCompanyId($company_id);
        /** @var ProductCategoryEntity $product_category_entity */
        foreach ($product_category_entities as $product_category_entity) {
            $product_categories[] = $product_category_entity->toArray();
        }
        return $product_categories;
    }

    /**
     * @param ProductCategorySpecification $spec
     * @param int                          $per_page
     * @return array
     */
    public function getProductCategoryList(ProductCategorySpecification $spec, $per_page)
    {
        $data = [];
        $product_category_repository = new ProductCategoryRepository();
        $paginate = $product_category_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var mixed                     $key
         * @var ProductCategoryRepository $product_category_entity
         */
        foreach ($paginate as $key => $product_category_entity) {
            $item = $product_category_entity->toArray();
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

    /**
     * 产品详情
     * @param $id
     * @return array
     */
    public function getProductCategoryInfo($id)
    {
        $data = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entity = $product_category_repository->fetch($id);
        if (isset($product_category_entity)) {
            $data = $product_category_entity->toArray();
        }
        return $data;
    }
}

