<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->decimal('weekly_budget', 10, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->decimal('weekly_budget', 10, 2)->nullable(false)->change();
        });
    }

};
