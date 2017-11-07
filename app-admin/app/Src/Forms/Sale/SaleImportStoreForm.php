<?php

namespace Huifang\Admin\Src\Forms\Sale;

use GuzzleHttp\Client;
use Huifang\Admin\Src\Forms\Form;
use Huifang\Src\Surport\Domain\Model\ResourceEntity;
use Huifang\Src\Surport\Infra\Repository\ResourceRepository;

class SaleImportStoreForm extends Form
{

    /**
     * @var array
     */
    public $rows;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sales' => 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
        ];
    }

    public function attributes()
    {
        return [
            'sales' => '销售线索',
        ];
    }


    public function validation()
    {
        $resource_id = array_get($this->data, 'sales');
        $resource_repository = new ResourceRepository();
        /** @var ResourceEntity $resource_entity */
        $resource_entity = $resource_repository->fetch($resource_id);
        $rows = $this->getUploadCsvData($resource_entity->url);

        $this->validateData($rows);

        $this->rows = $rows;
    }


    /**
     * 验证数据是否有重复
     */
    public function validateData($rows)
    {
        $collection = collect($rows);
        foreach ($rows as $row) {
            $count = $collection->where('0', $row[0])
                ->where('3', $row[3])->count();
            if ($count >= 2) {
                $this->addError('count', '导入数据中有重复！');
                break;
            }
        }
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function getUploadCsvData($url)
    {
        $rewords = [];
        $client = new Client();
        $exceptions = true;
        $allow_redirects = ['strict' => true];
        $response = $client->get($url, compact('exceptions', 'allow_redirects'));
        $contents = $response->getBody()->getContents();

        $encode = mb_detect_encoding($contents, array('ASCII', 'GB2312', 'GBK', 'UTF-8'));
        if ($encode != 'UTF-8') {
            $contents = iconv($encode, "UTF-8", $contents);
        }
        if (!empty($contents)) {
            $contents = str_replace("\r", "&", str_replace("\n", "", $contents));
            $items = explode('&', $contents);
            foreach ($items as $item) {
                $rewords[] = explode(',', $item);
            }
            if (empty($rewords[count($rewords) - 1][0])) {
                unset($rewords[count($rewords) - 1]);
            }
            unset($rewords[0]);
        }
        return array_values($rewords);
    }

}