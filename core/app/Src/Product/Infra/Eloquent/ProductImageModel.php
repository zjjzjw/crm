<?php
namespace Huifang\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImageModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_image';

    protected $dates = [
    ];

    protected $fillable = [
        'product_id',
        'image_id',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

}