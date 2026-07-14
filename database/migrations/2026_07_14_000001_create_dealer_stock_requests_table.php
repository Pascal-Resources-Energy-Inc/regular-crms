<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDealerStockRequestsTable extends Migration
{
    public function up(){
        if(Schema::hasTable('dealer_stock_requests')) return;
        Schema::create('dealer_stock_requests', function(Blueprint $table){
            $table->bigIncrements('id'); $table->unsignedBigInteger('dealer_id')->index(); $table->unsignedBigInteger('product_id')->index();
            $table->unsignedInteger('quantity'); $table->text('notes')->nullable(); $table->string('status',20)->default('Pending')->index();
            $table->unsignedBigInteger('reviewed_by')->nullable(); $table->timestamp('reviewed_at')->nullable(); $table->text('review_notes')->nullable(); $table->unsignedBigInteger('approved_order_id')->nullable(); $table->timestamps();
            $table->index(['dealer_id','product_id','status']);
        });
    }
    public function down(){ Schema::dropIfExists('dealer_stock_requests'); }
}
