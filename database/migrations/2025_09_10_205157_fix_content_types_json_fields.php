<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix any existing content types that have string data instead of JSON
        $contentTypes = DB::table('content_types')->get();
        
        foreach ($contentTypes as $contentType) {
            $updates = [];
            
            // Fix fields_schema
            if (!empty($contentType->fields_schema) && is_string($contentType->fields_schema)) {
                $decoded = json_decode($contentType->fields_schema, true);
                if ($decoded !== null) {
                    $updates['fields_schema'] = json_encode($decoded);
                } else {
                    $updates['fields_schema'] = json_encode([]);
                }
            } elseif (empty($contentType->fields_schema)) {
                $updates['fields_schema'] = json_encode([]);
            }
            
            // Fix layout_config
            if (!empty($contentType->layout_config) && is_string($contentType->layout_config)) {
                $decoded = json_decode($contentType->layout_config, true);
                if ($decoded !== null) {
                    $updates['layout_config'] = json_encode($decoded);
                } else {
                    $updates['layout_config'] = json_encode([]);
                }
            } elseif (empty($contentType->layout_config)) {
                $updates['layout_config'] = json_encode([]);
            }
            
            // Fix style_config
            if (!empty($contentType->style_config) && is_string($contentType->style_config)) {
                $decoded = json_decode($contentType->style_config, true);
                if ($decoded !== null) {
                    $updates['style_config'] = json_encode($decoded);
                } else {
                    $updates['style_config'] = json_encode([]);
                }
            } elseif (empty($contentType->style_config)) {
                $updates['style_config'] = json_encode([]);
            }
            
            // Fix field_groups
            if (!empty($contentType->field_groups) && is_string($contentType->field_groups)) {
                $decoded = json_decode($contentType->field_groups, true);
                if ($decoded !== null) {
                    $updates['field_groups'] = json_encode($decoded);
                } else {
                    $updates['field_groups'] = json_encode([]);
                }
            } elseif (empty($contentType->field_groups)) {
                $updates['field_groups'] = json_encode([]);
            }
            
            // Fix visibility_rules
            if (!empty($contentType->visibility_rules) && is_string($contentType->visibility_rules)) {
                $decoded = json_decode($contentType->visibility_rules, true);
                if ($decoded !== null) {
                    $updates['visibility_rules'] = json_encode($decoded);
                } else {
                    $updates['visibility_rules'] = json_encode([]);
                }
            } elseif (empty($contentType->visibility_rules)) {
                $updates['visibility_rules'] = json_encode([]);
            }
            
            // Update if there are changes
            if (!empty($updates)) {
                DB::table('content_types')
                    ->where('id', $contentType->id)
                    ->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
};