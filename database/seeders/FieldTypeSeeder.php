<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FieldManager;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fieldTypes = [
            [
                'name' => 'Text Area',
                'slug' => 'text-area',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text',
                'type' => 'textarea',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 1,
                'field_config' => [
                    'rows' => 4,
                    'placeholder' => 'Enter text...',
                    'max_length' => 1000
                ],
                'validation_rules' => [
                    'required' => false,
                    'max' => 1000
                ]
            ],
            [
                'name' => 'Add to Cart',
                'slug' => 'add-to-cart',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text',
                'type' => 'button',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 2,
                'field_config' => [
                    'button_text' => 'Add to Cart',
                    'button_class' => 'btn btn-primary',
                    'action' => 'add_to_cart'
                ],
                'validation_rules' => [
                    'required' => false
                ]
            ],
            [
                'name' => 'Email',
                'slug' => 'email',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text',
                'type' => 'email',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 3,
                'field_config' => [
                    'placeholder' => 'Enter email address',
                    'pattern' => 'email'
                ],
                'validation_rules' => [
                    'required' => true,
                    'email' => true
                ]
            ],
            [
                'name' => 'Text Input',
                'slug' => 'text-input',
                'description' => 'A simple text input field for single-line text entry',
                'type' => 'text',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 4,
                'field_config' => [
                    'placeholder' => 'Enter text',
                    'max_length' => 255
                ],
                'validation_rules' => [
                    'required' => false,
                    'max' => 255
                ]
            ],
            [
                'name' => 'Number Input',
                'slug' => 'number-input',
                'description' => 'A numeric input field for numbers and calculations',
                'type' => 'number',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 5,
                'field_config' => [
                    'min' => 0,
                    'max' => 999999,
                    'step' => 1
                ],
                'validation_rules' => [
                    'required' => false,
                    'numeric' => true
                ]
            ],
            [
                'name' => 'Select Dropdown',
                'slug' => 'select-dropdown',
                'description' => 'A dropdown select field with predefined options',
                'type' => 'select',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 6,
                'field_config' => [
                    'options' => [
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                        'option3' => 'Option 3'
                    ],
                    'multiple' => false
                ],
                'validation_rules' => [
                    'required' => false
                ]
            ],
            [
                'name' => 'Checkbox',
                'slug' => 'checkbox',
                'description' => 'A checkbox field for boolean values',
                'type' => 'checkbox',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 7,
                'field_config' => [
                    'label' => 'Check this option',
                    'value' => 1
                ],
                'validation_rules' => [
                    'required' => false
                ]
            ],
            [
                'name' => 'File Upload',
                'slug' => 'file-upload',
                'description' => 'A file upload field for documents and media',
                'type' => 'file',
                'source' => 'centralized',
                'version' => '1.0.0',
                'author' => 'System',
                'is_active' => true,
                'is_installed' => true,
                'sort_order' => 8,
                'field_config' => [
                    'accept' => '*/*',
                    'max_size' => '10MB',
                    'multiple' => false
                ],
                'validation_rules' => [
                    'required' => false,
                    'file' => true,
                    'max' => 10240
                ]
            ]
        ];

        foreach ($fieldTypes as $fieldType) {
            FieldManager::updateOrCreate(
                ['slug' => $fieldType['slug']],
                $fieldType
            );
        }
    }
}
