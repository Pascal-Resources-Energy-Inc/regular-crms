<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddClientTagToTransactionDetailsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('transaction_details', 'client_tag')) {
            Schema::table('transaction_details', function (Blueprint $table) {
                $table->string('client_tag')->nullable()->after('client_id');
            });
        }

        // Guest and Others are transaction tags, not Client records.
        // Their transactions therefore have no client_id.
        if (DB::getDriverName() === 'mysql') {
            $columns = DB::select("SHOW COLUMNS FROM `transaction_details` LIKE 'client_id'");

            if (!empty($columns) && strtoupper($columns[0]->Null) !== 'YES') {
                DB::statement('ALTER TABLE `transaction_details` MODIFY `client_id` ' . $columns[0]->Type . ' NULL');
            }
        }
    }

    public function down()
    {
        if (Schema::hasColumn('transaction_details', 'client_tag')) {
            Schema::table('transaction_details', function (Blueprint $table) {
                $table->dropColumn('client_tag');
            });
        }
    }
}
