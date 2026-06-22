<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTransactionDetailsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('transaction_details', 'status')) {
            Schema::table('transaction_details', function (Blueprint $table) {
                $table->string('status')->default('Completed')->after('payment_method');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('transaction_details', 'status')) {
            Schema::table('transaction_details', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
