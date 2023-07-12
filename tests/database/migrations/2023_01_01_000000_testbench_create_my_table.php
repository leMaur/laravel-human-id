<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('my_table', static function (Blueprint $table) {
            $table->id();
            $table->huid();
            $table->timestamps();
        });
    }
};
