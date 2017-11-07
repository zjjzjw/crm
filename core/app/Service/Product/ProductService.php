<?php

namespace Huifang\Service\Product;


use Huifang\Src\Product\Domain\Model\AscriptionType;
use Huifang\Src\Product\Domain\Model\ProductCategoryEntity;
use Huifang\Src\Product\Domain\Model\ProductEntity;
use Huifang\Src\Product\Domain\Model\RivalEntity;
use Huifang\Src\Product\Infra\Repository\ProductCategoryRepository;
use Huifang\Src\Product\Infra\Repository\ProductRepository;
use Huifang\Src\Product\Domain\Model\ProductSpecification;
use Huifang\Src\Product\Infra\Repository\RivalRepository;
use Huifang\Src\Surport\Domain\Model\ResourceEntity;
use Huifang\Src\Surport\Infra\Repository\ResourceRepository;

class ProductService
{
    /**
     * 通过公司得到所有的数据
     * @param int $company_id
     * @return array
     */
    public function getProductsByCompanyId($company_id, $ascription)
    {
        $products = [];
        $product_repository = new ProductRepository();
        $product_entities = $product_repository->getProductsByCompanyId($company_id, $ascription);
        /** @var ProductEntity $product_entity */
        foreach ($product_entities as $product_entity) {
            $products[] = $product_entity->toArray();
        }
        return $products;
    }

    /**
     * 得到本公司产品，并按照分组分类
     * @param int $company_id
     * @param int $ascription
     */
    public function getGroupProductsByCompanyId($company_id, $ascription)
    {
        $data = [];
        $group_products = [];
        $product_repository = new ProductRepository();
        $product_entities = $product_repository->getProductsByCompanyId($company_id, $ascription);
        /** @var ProductEntity $product_entity */
        foreach ($product_entities as $product_entity) {
            $group_products[$product_entity->category_id][] = $product_entity->toArray();
        }
        $category_ids = [];
        foreach ($group_products as $key => $products) {
            $category_ids[] = $key;
        }
        $product_categories = [];
        $product_category_repository = new ProductCategoryRepository();
        $product_category_entities = $product_category_repository->getProductCategoriesByCompanyId($company_id);
        /** @var ProductCategoryEntity $product_category_entity */
        foreach ($product_category_entities as $product_category_entity) {
            if (in_array($product_category_entity->id, $category_ids)) {
                $item = $product_category_entity->toArray();
                $item['nodes'] = $group_products[$product_category_entity->id] ?? [];
                $data[] = $item;
            }
        }
        return $data;
    }


    /**
     * @param ProductSpecification  $spec
     * @param                       $per_page
     * @return array
     */
    public function getProductList(ProductSpecification $spec, $per_page)
    {
        $data = [];
        $product_repository = new ProductRepository();
        $paginate = $product_repository->search($spec, $per_page);
        $ascription_types = AscriptionType::acceptableEnums();

        $items = [];
        $rival_repository = new RivalRepository();
        /**
         * @var mixed         $key
         * @var ProductEntity $product_entity
         */
        foreach ($paginate as $key => $product_entity) {
            $item = $product_entity->toArray();
            $item['ascription_type_name'] = $ascription_types[$product_entity->ascription] ?? '';
            if ($item['ascription'] == AscriptionType::TYPE_RIVAL) {
                /** @var RivalEntity $rival_entity */
                $rival_entity = $rival_repository->fetch($product_entity->ascription_id);
                if (isset($rival_entity)) {
                    $item['rival_name'] = $rival_entity->name;
                }
            } else {
                $item['rival_name'] = request()->user()->company->name;
            }
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
    public function getProductInfo($id)
    {
        $data = [];
        $product_repository = new ProductRepository();
        /** @var ProductEntity $product_entity */
        $product_entity = $product_repository->fetch($id);


        if (isset($product_entity)) {
            $data = $product_entity->toArray();
            $data['price'] = intval($product_entity->price);
            if (!empty($product_entity->attribfield)) {
                $data['params'] = \GuzzleHttp\json_decode($product_entity->attribfield, true);
            }
            if ($product_entity->ascription == AscriptionType::TYPE_OWNER) {
                $data['company_name'] = request()->user()->company->name;
            } else if ($product_entity->ascription == AscriptionType::TYPE_RIVAL) {
                $rival_repository = new RivalRepository();
                /** @var RivalEntity $rival_entity */
                $rival_entity = $rival_repository->fetch($product_entity->ascription_id);
                if (isset($rival_entity)) {
                    $data['company_name'] = $rival_entity->name;
                }
            }
            $product_category_repository = new ProductCategoryRepository();
            /** @var ProductCategoryEntity $product_category_entity */
            $product_category_entity = $product_category_repository->fetch($product_entity->category_id);
            if (isset($product_category_entity)) {
                $data['category_name'] = $product_category_entity->name;
            }
            $product_images = [];
            if (!empty($product_entity->product_images)) {
                $resource_repository = new ResourceRepository();
                $image_entities = $resource_repository->getResourceUrlByIds($product_entity->product_images);
                /** @var ResourceEntity $image_entity */
                foreach ($image_entities as $image_entity) {
                    $item = [];
                    $item['image_id'] = $image_entity->id;
                    $item['url'] = $image_entity->url;
                    $product_images[] = $item;
                }
            }
            $data['product_images'] = $product_images;
        }

        return $data;
    }


    public function getProductArea()
    {
        $data = [];
        $ascription_types = AscriptionType::acceptableEnums();
        $rival_service = new RivalService();
        foreach ($ascription_types as $key => $name) {
            $item = [];
            $item['id'] = $key;
            $item['name'] = $name;
            if ($key == AscriptionType::TYPE_OWNER) {
                $node['id'] = request()->user()->company->id;
                $node['name'] = request()->user()->company->name;
                $item['nodes'][] = $node;
            } else {
                $company_id = request()->user()->company->id;
                $rivals = $rival_service->getRivalsByCompanyId($company_id);
                $item['nodes'] = $rivals;
            }
            $data[] = $item;
        }
        return $data;
    }

    /**
     * 得到公司列表
     * @return  array
     */
    public function getProductCompanyList()
    {
        $companies = [];
        $company_id = request()->user()->company->id;
        $item['id'] = $company_id;
        $item['name'] = request()->user()->company->name;
        $item['type'] = AscriptionType::TYPE_OWNER;
        $companies[] = $item;
        $rival_service = new RivalService();
        $rivals = $rival_service->getRivalsByCompanyId($company_id);

        foreach ($rivals as $rival) {
            $item = [];
            $item['id'] = $rival['id'];
            $item['name'] = $rival['name'];
            $item['type'] = AscriptionType::TYPE_RIVAL;
            $companies[] = $item;
        }
        return $companies;
    }

    /**
     * @param ProductSpecification $spec
     */
    public function getProductsBySpecification($spec)
    {
        $items = [];
        $product_repository = new ProductRepository();
        $product_entities = $product_repository->getProductsBySpecification($spec);
        /** @var ProductEntity $product_entity */
        foreach ($product_entities as $product_entity) {
            $item = $product_entity->toArray();
            $items[] = $item;
        }
        return $items;
    }

}

