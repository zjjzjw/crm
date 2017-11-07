<?php
namespace Huifang\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $dates = [
    ];

    protected $fillable = [
        'company_id',
        'category_id',
        'name',
        'ascription',
        'ascription_id',
        'price',
        'attribfield',
    ];


    public function product_images()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id', 'id');
    }
}