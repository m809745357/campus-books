<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 9,
                'title' => '图书平台',
                'icon' => 'fa-bookmark',
                'uri' => '/bookmark',
                'created_at' => '2017-11-10 09:38:51',
                'updated_at' => '2017-11-18 10:57:27',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 8,
                'order' => 10,
                'title' => '图书分类',
                'icon' => 'fa-archive',
                'uri' => '/bookmark/categories',
                'created_at' => '2017-11-10 09:47:17',
                'updated_at' => '2017-11-18 10:57:27',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 11,
                'title' => '在线售书',
                'icon' => 'fa-bars',
                'uri' => '/bookmark/books',
                'created_at' => '2017-11-10 09:48:21',
                'updated_at' => '2017-11-18 14:37:17',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 13,
                'title' => '问答论坛',
                'icon' => 'fa-cc-diners-club',
                'uri' => '/club',
                'created_at' => '2017-11-10 09:51:10',
                'updated_at' => '2017-11-18 10:57:27',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 8,
                'title' => '用户管理',
                'icon' => 'fa-user-plus',
                'uri' => '/member',
                'created_at' => '2017-11-16 10:46:56',
                'updated_at' => '2017-11-18 10:57:47',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 11,
                'order' => 14,
                'title' => '问答分类',
                'icon' => 'fa-archive',
                'uri' => '/club/channels',
                'created_at' => '2017-11-17 09:53:15',
                'updated_at' => '2017-11-18 10:57:27',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 11,
                'order' => 15,
                'title' => '提问管理',
                'icon' => 'fa-commenting-o',
                'uri' => '/club/thread',
                'created_at' => '2017-11-17 09:59:02',
                'updated_at' => '2017-11-18 10:57:28',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 11,
                'order' => 16,
                'title' => '回复管理',
                'icon' => 'fa-commenting',
                'uri' => '/club/reply',
                'created_at' => '2017-11-17 10:00:27',
                'updated_at' => '2017-11-18 10:57:28',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 17,
                'title' => '账户管理',
                'icon' => 'fa-anchor',
                'uri' => '/account',
                'created_at' => '2017-11-17 11:57:57',
                'updated_at' => '2017-11-17 14:56:42',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 16,
                'order' => 18,
                'title' => '充值中心',
                'icon' => 'fa-book',
                'uri' => '/account/recharge',
                'created_at' => '2017-11-17 11:59:18',
                'updated_at' => '2017-11-17 14:56:42',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 16,
                'order' => 19,
                'title' => '账户明细',
                'icon' => 'fa-bar-chart-o',
                'uri' => '/account/bill',
                'created_at' => '2017-11-17 13:13:18',
                'updated_at' => '2017-11-17 14:56:42',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 8,
                'order' => 12,
                'title' => '求购信息',
                'icon' => 'fa-bullhorn',
                'uri' => '/bookmark/demand',
                'created_at' => '2017-11-17 14:55:51',
                'updated_at' => '2017-11-18 10:57:27',
            ),
        ));
        
        
    }
}