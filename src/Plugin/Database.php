<?php
namespace Amuz\XePlugin\DynamicFieldExtend\Plugin;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Database
{
    public static function create()
    {
        // 비메오 디렉토리 table
        if (Schema::hasTable('vimeo_directory') === false) {
            Schema::create('vimeo_directory', function (Blueprint $table) {
                $table->increments('id')->comment('디렉토리 ID');
                $table->string('name')->comment('디렉토리명칭');
                $table->char('delete_status', 1)->comment('delete 상태');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('vimeo_video') === false) {
            Schema::create('vimeo_video', function (Blueprint $table) {
                $table->increments('id')->comment('영상 id');
                $table->integer('directory_id')->comment('디렉토리 ID');
                $table->string('name')->comment('영상 명칭');
                $table->integer('video_duration')->comment('재생시간');
                $table->string('thumbnail', 100)->comment('썸네일 사이즈 1280 x 720 by Vimeo');
                $table->string('thumbnail_overlay')->comment('썸네일 -재생버튼 1280 x 720 by Vimeo');
                $table->char('delete_status', 1)->comment('delete 상태');
                $table->timestamps();
            });
        }
    }
}
