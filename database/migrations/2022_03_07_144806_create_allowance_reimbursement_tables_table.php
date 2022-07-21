<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllowanceReimbursementTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowance_reimbursement', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('user_grade')->nullable();
            $table->string('dated')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->integer('type')->nullable();
            $table->integer('travel_type')->nullable();
            $table->text('description')->nullable();
            $table->string('client')->nullable();
            $table->string('actual')->nullable();
            $table->string('amount')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->nullable();
            $table->string('paid_status')->nullable();
            $table->string('other_client')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allowance_reimbursement');
    }
}
