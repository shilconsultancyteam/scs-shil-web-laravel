<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   // In the new migration file
// ...
public function up()
{
    Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('job_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->text('cover_letter');
        $table->string('portfolio_link')->nullable();
        $table->string('cv_path');
        $table->timestamps();
    });
}
// ...

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
