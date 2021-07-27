<?php
namespace Amuz\XePlugin\DynamicFieldExtend\Models;

use Xpressengine\Database\Eloquent\DynamicModel;

class VimeoDirectory extends DynamicModel
{
    protected $table = 'vimeo_directory';

    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];

    public $primaryKey = 'id';

    public $timestamps = true;

//    public function categoryItem()
//    {
//        return $this->hasOne(CategoryItem::class, 'id', 'item_id');
//    }
}
