<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $oldname = 'name';
        $newname = 'guestbook';
        Schema::rename($oldname, $newname);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
