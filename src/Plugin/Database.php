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
                $table->timestamps();
            });
        }

        if (Schema::hasTable('vimeo_video') === false) {
            Schema::create('vimeo_video', function (Blueprint $table) {
                $table->increments('id')->comment('영상 id');
                $table->string('directory_id')->comment('디렉토리 ID');
                $table->string('name')->comment('영상 명칭');
                $table->string('video_duration')->comment('재생시간');
                $table->timestamps();
            });
        }


        if (Schema::hasTable('vimeo_video') === false) {
            Schema::create('vimeo_video', function (Blueprint $table) {
                $table->increments('id')->comment('영상 id');
                $table->string('directory_id')->comment('디렉토리 ID');
                $table->string('name')->comment('영상 명칭');
                $table->string('video_duration')->comment('재생시간');
                $table->timestamps();
            });
        }
    }
}
