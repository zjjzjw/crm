<?php
namespace Huifang\Supports;

abstract class Entity implements \JsonSerializable
{
    protected $created_at; //创建时间
    protected $updated_at; //更新时间

    protected $_invalid_fields;

    protected abstract function rules();

    /**
     * 检查对象参数的合法性
     * @param bool $rules_filter 是否只对值存在字段验证
     * @return bool
     */
    public function validate($rules_filter = true)
    {
        if (empty($this->rules())) {
            return true;
        }
        $array = $this->toArray($rules_filter);
        $rules = array_intersect_key($this->rules(), $array);

        /** @var $validate \Illuminate\Validation\Validator */
        $validate = \Validator::make($array, $rules);
        if ($validate->fails()) {
            $this->_invalid_fields = $validate->invalid();
            return false;
        }

        return true;
    }

    public function getInvalidKeys()
    {
        return array_keys($this->_invalid_fields);
    }

    /**
     * 初始化对象
     * @param $arr array 数组数据
     * @return bool
     */
    public function init($arr)
    {
        foreach ($this as $key => $value) {
            if (isset($arr[$key])) {
                $method = 'set' . str_replace('_', '', $key);
                if (method_exists($this, $method)) {
                    call_user_func(array($this, $method), $arr[$key]);
                } else {
                    $this->$key = $arr[$key];
                }
            }
        }
    }

    /**
     * 对象转数组
     * @param $is_filter_null bool 是否过滤空值,false=否(默认)，true=是
     * @return array
     */
    public function toArray($is_filter_null = false)
    {
        $arr = array();
        foreach ($this as $key => $value) {
            if ($is_filter_null) {
                if (isset($value)) {
                    $arr[$key] = $value;
                }
            } else {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function isEmpty($is_filter_null = false)
    {
        return $this->toArray($is_filter_null) ? false : true;
    }
}
