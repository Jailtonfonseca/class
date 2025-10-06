<?php
/* Version 1.2 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* Add translation column */
if (!Schema::hasColumn('countries', 'map_zoom')) {
    Schema::table('countries', function (Blueprint $table) {
        $table->tinyInteger('map_zoom')->default(5)->after('longitude');
    });
}

/* Add filter column */
if (!Schema::hasColumn('custom_fields', 'use_as_filter')) {
    Schema::table('custom_fields', function (Blueprint $table) {
        $table->boolean('use_as_filter')->default(false)->after('required');
        $table->boolean('show_in_view')->default(false)->after('use_as_filter');
        $table->boolean('active')->default(true)->after('show_in_view');
    });
}
