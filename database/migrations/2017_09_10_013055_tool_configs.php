<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ToolConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');
            $table->string('site', '255');
            $table->string('start_title_code');
            $table->string('end_title_code');
            $table->string('start_content_code');
            $table->string('end_content_code');
            $table->string('url_child');
            $table->string('start_url_child');
            $table->string('end_url_child');
            $table->string('url_parent');
            $table->string('start_url_parent');
            $table->string('end_url_parent');
            $table->timestamps();
        });

        DB::table('tool_configs')->insert([
            'site' => 'http://truyensex88.net',
            'start_title_code' => '<h2><em><strong>',
            'end_title_code' => '</strong></em></h2>',
            'start_content_code' => '<div id="content" class="pad">',
            'end_content_code' => '<a class="addthis_button_google_plusone"',
            'url_child' => '/',
            'start_url_child' => '<div id="wp_page" class="wp-pagenavi">',
            'end_url_child' => '</a></p></div></div>',
            'url_parent' => '/page/',
            'start_url_parent' => '',
            'end_url_parent' => ''
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tool_configs');
    }
}
