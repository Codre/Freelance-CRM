<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('task_id')->nullable()->unsigned()->index();
            $table->boolean('payed')->index();
            $table->decimal('sum', 14);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', static function (Blueprint $table) {
            $table->dropIndex(['task_id']);
            $table->dropIndex(['payed']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['project_id']);
        });
        Schema::dropIfExists('invoices');
    }
}
