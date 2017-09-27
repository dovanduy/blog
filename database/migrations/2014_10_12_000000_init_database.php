<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public $TYPE_1 = 'Truyện người lớn';
    public $TYPE_2 = 'Truyện loạn luân';
    public $TYPE_3 = 'Truyện phá trinh';
    public $TYPE_4 = 'Truyện ma';

    public function up()
    {
        Schema::defaultStringLength(191);
        // Create Role table
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        // Insert role init
        $roles = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Quản lý'],
            ['id' => 3, 'name' => 'Xe bus']
        ];

        foreach($roles as $role) {
            DB::table('roles')->insert($role);
        }

        // Create Users tale
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 50)->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('ip')->nullable();
            $table->tinyInteger('role')->references('id')->on('roles')->default(0);
            $table->timestamps();
        });

        // Insert user init
        DB::table('users')->insert([[
            'name' => 'Giám mục',
            'email' => 'admin',
            'password' => bcrypt('story123'),
            'role' => 1
        ],
            [
                'name' => 'Cố vấn',
                'email' => 'manager1',
                'password' => bcrypt('manager123'),
                'role' => 2
            ],
            [
                'name' => 'Thái giám',
                'email' => 'manager2',
                'password' => bcrypt('manager123'),
                'role' => 2
            ],
            [
                'name' => 'Nhân viên',
                'email' => 'membership',
                'password' => bcrypt('membership123'),
                'role' => 3
            ]]);

//        create type table
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_unicode');
            $table->timestamps();
        });
        // Insert type init
        $types = [
            ['id' => 1, 'name' => $this->TYPE_1, 'name_unicode' => changeTitle($this->TYPE_1)],
            ['id' => 2, 'name' => $this->TYPE_2, 'name_unicode' => changeTitle($this->TYPE_2)],
            ['id' => 3, 'name' => $this->TYPE_3, 'name_unicode' => changeTitle($this->TYPE_3)],
            ['id' => 4, 'name' => $this->TYPE_4, 'name_unicode' => changeTitle($this->TYPE_4)]
        ];

        foreach($types as $type) {
            DB::table('types')->insert($type);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
