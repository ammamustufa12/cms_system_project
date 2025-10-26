<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FieldGroup;
use App\Models\Field;

class FieldsSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create field groups
        $addressGroup = FieldGroup::firstOrCreate(
            ['name' => 'Address'],
            [
                'description' => 'Address related fields',
                'source' => 'centralized',
                'access_rights' => 'public',
                'is_active' => true,
                'sort_order' => 1
            ]
        );

        $pricingGroup = FieldGroup::firstOrCreate(
            ['name' => 'Pricing'],
            [
                'description' => 'Pricing related fields',
                'source' => 'centralized',
                'access_rights' => 'public',
                'is_active' => true,
                'sort_order' => 2
            ]
        );

        $contactGroup = FieldGroup::firstOrCreate(
            ['name' => 'Contact Details'],
            [
                'description' => 'Contact information fields',
                'source' => 'centralized',
                'access_rights' => 'public',
                'is_active' => true,
                'sort_order' => 3
            ]
        );

        // Create fields for Address group
        Field::create([
            'label' => 'Street Address',
            'alias' => 'street',
            'type' => 'text',
            'field_group_id' => $addressGroup->id,
            'description' => 'Street address field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Field::create([
            'label' => 'City',
            'alias' => 'city',
            'type' => 'text',
            'field_group_id' => $addressGroup->id,
            'description' => 'City field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 2
        ]);

        Field::create([
            'label' => 'State',
            'alias' => 'state',
            'type' => 'dropdown',
            'field_group_id' => $addressGroup->id,
            'description' => 'State selection field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Create fields for Contact Details group
        Field::create([
            'label' => 'Cell',
            'alias' => 'cell',
            'type' => 'mask',
            'field_group_id' => $contactGroup->id,
            'description' => 'Cell phone number field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Field::create([
            'label' => 'Personal Email',
            'alias' => 'email-home',
            'type' => 'email',
            'field_group_id' => $contactGroup->id,
            'description' => 'Personal email address field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 2
        ]);

        Field::create([
            'label' => 'Work Email',
            'alias' => 'email-work',
            'type' => 'email',
            'field_group_id' => $contactGroup->id,
            'description' => 'Work email address field',
            'viewable' => 'public',
            'is_active' => false,
            'sort_order' => 3
        ]);

        // Create additional fields to match the image
        for ($i = 4; $i <= 12; $i++) {
            Field::create([
                'label' => 'Field ' . $i,
                'alias' => 'field_' . $i,
                'type' => 'text',
                'field_group_id' => $addressGroup->id,
                'description' => 'Sample field ' . $i,
                'viewable' => 'public',
                'is_active' => true,
                'sort_order' => $i
            ]);
        }

        // Create more fields for different groups
        for ($i = 13; $i <= 20; $i++) {
            Field::create([
                'label' => 'Contact Field ' . $i,
                'alias' => 'contact_field_' . $i,
                'type' => 'text',
                'field_group_id' => $contactGroup->id,
                'description' => 'Contact field ' . $i,
                'viewable' => 'public',
                'is_active' => true,
                'sort_order' => $i
            ]);
        }

        // Create pricing fields
        Field::create([
            'label' => 'Price',
            'alias' => 'price',
            'type' => 'number',
            'field_group_id' => $pricingGroup->id,
            'description' => 'Price field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Field::create([
            'label' => 'Currency',
            'alias' => 'currency',
            'type' => 'dropdown',
            'field_group_id' => $pricingGroup->id,
            'description' => 'Currency selection field',
            'viewable' => 'public',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Create more fields to reach the pagination shown in image
        for ($i = 21; $i <= 50; $i++) {
            $group = $i % 3 == 0 ? $pricingGroup : ($i % 2 == 0 ? $contactGroup : $addressGroup);
            Field::create([
                'label' => 'Sample Field ' . $i,
                'alias' => 'sample_field_' . $i,
                'type' => 'text',
                'field_group_id' => $group->id,
                'description' => 'Sample field ' . $i,
                'viewable' => 'public',
                'is_active' => true,
                'sort_order' => $i
            ]);
        }
    }
}