<?php
namespace Amuz\XePlugin\DynamicFieldExtend\Models;

use Xpressengine\Database\Eloquent\DynamicModel;

class VimeoVideo extends DynamicModel
{
    protected $table = 'vimeo_video';

    protected $fillable = ['id', 'directory_id', 'name', 'video_duration', 'thumbnail', 'thumbnail_overlay', 'delete_status', 'created_at', 'updated_at'];

    public $primaryKey = 'id';

    public $timestamps = true;

//    public function categoryItem()
//    {
//        return $this->hasOne(CategoryItem::class, 'id', 'item_id');
//    }
}
