<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_detail_id');
            $table->string('name'); // e.g., "HANDLING FEE (HF)"
            $table->decimal('amount', 10, 2); // e.g., 100.00
            $table->timestamps();
            
            // Foreign key relationship
            $table->foreign('order_detail_id')
                  ->references('id')
                  ->on('order_details')
                  ->onDelete('cascade');
            
            // Index for faster queries
            $table->index('order_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail_charges');
    }
}
