<?php

use Illuminate\Database\Migrations\Migration;

/**
 * This migration was originally committed empty. Keep its recorded identity
 * intact while leaving admin_profiles creation to the following migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        // The admin_profiles table is created by the next migration.
    }

    public function down(): void
    {
        // Do not drop a table owned by another migration.
    }
};
