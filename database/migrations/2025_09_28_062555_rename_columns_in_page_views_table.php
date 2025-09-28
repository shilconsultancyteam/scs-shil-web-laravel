<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->renameColumn('pages', 'page');   // pages → page
            $table->renameColumn('veiws', 'views');  // veiws → views
        });
    }

    public function down()
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->renameColumn('page', 'pages');
            $table->renameColumn('views', 'veiws');
        });
    }
};
