<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (env('DB_CONNECTION') === 'sqlite_testing'){
                $table->unsignedInteger('user_id')->default(0);
            } else {
                $table->unsignedInteger('user_id');
            }

            // $table->foreignId('user_id')->constrained();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
