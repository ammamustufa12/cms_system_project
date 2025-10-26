<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentType;
use App\Models\FieldManager;

class ContentTypeFieldsSeeder extends Seeder
{
    public function run()
    {
        // Get available field types
        $fieldTypes = FieldManager::where('is_active', true)->get()->keyBy('type');
        
        // Define content types with their fields
        $contentTypeFields = [
            'Blog Post' => [
                'title' => [
                    'name' => 'Title',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                    'options' => [
                        'max_length' => 255,
                        'placeholder' => 'Enter blog title'
                    ]
                ],
                'content' => [
                    'name' => 'Content',
                    'type' => 'textarea',
                    'required' => true,
                    'order' => 2,
                    'options' => [
                        'rows' => 10,
                        'placeholder' => 'Write your blog content...'
                    ]
                ],
                'author' => [
                    'name' => 'Author',
                    'type' => 'text',
                    'required' => false,
                    'order' => 3,
                    'options' => [
                        'placeholder' => 'Author name'
                    ]
                ],
                'featured_image' => [
                    'name' => 'Featured Image',
                    'type' => 'file',
                    'required' => false,
                    'order' => 4,
                    'options' => [
                        'allowed_types' => ['jpg', 'png', 'gif'],
                        'max_size' => '5MB'
                    ]
                ],
                'category' => [
                    'name' => 'Category',
                    'type' => 'select',
                    'required' => true,
                    'order' => 5,
                    'options' => [
                        'choices' => [
                            'Technology' => 'Technology',
                            'Business' => 'Business',
                            'Lifestyle' => 'Lifestyle',
                            'Health' => 'Health'
                        ]
                    ]
                ],
                'published_at' => [
                    'name' => 'Published Date',
                    'type' => 'text',
                    'required' => false,
                    'order' => 6,
                    'options' => [
                        'placeholder' => 'YYYY-MM-DD'
                    ]
                ]
            ],
            
            'Portfolio' => [
                'project_name' => [
                    'name' => 'Project Name',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                    'options' => [
                        'max_length' => 255,
                        'placeholder' => 'Enter project name'
                    ]
                ],
                'description' => [
                    'name' => 'Description',
                    'type' => 'textarea',
                    'required' => true,
                    'order' => 2,
                    'options' => [
                        'rows' => 6,
                        'placeholder' => 'Project description...'
                    ]
                ],
                'client' => [
                    'name' => 'Client',
                    'type' => 'text',
                    'required' => false,
                    'order' => 3,
                    'options' => [
                        'placeholder' => 'Client name'
                    ]
                ],
                'project_url' => [
                    'name' => 'Project URL',
                    'type' => 'text',
                    'required' => false,
                    'order' => 4,
                    'options' => [
                        'placeholder' => 'https://example.com'
                    ]
                ],
                'technologies' => [
                    'name' => 'Technologies',
                    'type' => 'select',
                    'required' => false,
                    'order' => 5,
                    'options' => [
                        'choices' => [
                            'PHP' => 'PHP',
                            'Laravel' => 'Laravel',
                            'React' => 'React',
                            'Vue.js' => 'Vue.js',
                            'JavaScript' => 'JavaScript',
                            'CSS' => 'CSS',
                            'HTML' => 'HTML'
                        ]
                    ]
                ],
                'project_image' => [
                    'name' => 'Project Image',
                    'type' => 'file',
                    'required' => false,
                    'order' => 6,
                    'options' => [
                        'allowed_types' => ['jpg', 'png', 'gif'],
                        'max_size' => '10MB'
                    ]
                ]
            ],
            
            'Team Manager' => [
                'name' => [
                    'name' => 'Full Name',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                    'options' => [
                        'max_length' => 255,
                        'placeholder' => 'Enter full name'
                    ]
                ],
                'position' => [
                    'name' => 'Position',
                    'type' => 'text',
                    'required' => true,
                    'order' => 2,
                    'options' => [
                        'placeholder' => 'Job title'
                    ]
                ],
                'bio' => [
                    'name' => 'Bio',
                    'type' => 'textarea',
                    'required' => false,
                    'order' => 3,
                    'options' => [
                        'rows' => 4,
                        'placeholder' => 'Team member bio...'
                    ]
                ],
                'email' => [
                    'name' => 'Email',
                    'type' => 'email',
                    'required' => false,
                    'order' => 4,
                    'options' => [
                        'placeholder' => 'team@example.com'
                    ]
                ],
                'phone' => [
                    'name' => 'Phone',
                    'type' => 'text',
                    'required' => false,
                    'order' => 5,
                    'options' => [
                        'placeholder' => '+1234567890'
                    ]
                ],
                'profile_image' => [
                    'name' => 'Profile Image',
                    'type' => 'file',
                    'required' => false,
                    'order' => 6,
                    'options' => [
                        'allowed_types' => ['jpg', 'png', 'gif'],
                        'max_size' => '5MB'
                    ]
                ],
                'department' => [
                    'name' => 'Department',
                    'type' => 'select',
                    'required' => false,
                    'order' => 7,
                    'options' => [
                        'choices' => [
                            'Development' => 'Development',
                            'Design' => 'Design',
                            'Marketing' => 'Marketing',
                            'Sales' => 'Sales',
                            'Management' => 'Management'
                        ]
                    ]
                ]
            ],
            
            'Resturents' => [
                'restaurant_name' => [
                    'name' => 'Restaurant Name',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                    'options' => [
                        'max_length' => 255,
                        'placeholder' => 'Enter restaurant name'
                    ]
                ],
                'description' => [
                    'name' => 'Description',
                    'type' => 'textarea',
                    'required' => true,
                    'order' => 2,
                    'options' => [
                        'rows' => 6,
                        'placeholder' => 'Restaurant description...'
                    ]
                ],
                'cuisine_type' => [
                    'name' => 'Cuisine Type',
                    'type' => 'select',
                    'required' => true,
                    'order' => 3,
                    'options' => [
                        'choices' => [
                            'Italian' => 'Italian',
                            'Chinese' => 'Chinese',
                            'Indian' => 'Indian',
                            'Mexican' => 'Mexican',
                            'American' => 'American',
                            'Thai' => 'Thai',
                            'Japanese' => 'Japanese'
                        ]
                    ]
                ],
                'address' => [
                    'name' => 'Address',
                    'type' => 'textarea',
                    'required' => true,
                    'order' => 4,
                    'options' => [
                        'rows' => 3,
                        'placeholder' => 'Restaurant address...'
                    ]
                ],
                'phone' => [
                    'name' => 'Phone',
                    'type' => 'text',
                    'required' => false,
                    'order' => 5,
                    'options' => [
                        'placeholder' => '+1234567890'
                    ]
                ],
                'website' => [
                    'name' => 'Website',
                    'type' => 'text',
                    'required' => false,
                    'order' => 6,
                    'options' => [
                        'placeholder' => 'https://restaurant.com'
                    ]
                ],
                'rating' => [
                    'name' => 'Rating',
                    'type' => 'number',
                    'required' => false,
                    'order' => 7,
                    'options' => [
                        'min' => 1,
                        'max' => 5,
                        'step' => 0.1
                    ]
                ],
                'restaurant_image' => [
                    'name' => 'Restaurant Image',
                    'type' => 'file',
                    'required' => false,
                    'order' => 8,
                    'options' => [
                        'allowed_types' => ['jpg', 'png', 'gif'],
                        'max_size' => '10MB'
                    ]
                ]
            ],
            
            'Testimonials' => [
                'customer_name' => [
                    'name' => 'Customer Name',
                    'type' => 'text',
                    'required' => true,
                    'order' => 1,
                    'options' => [
                        'max_length' => 255,
                        'placeholder' => 'Enter customer name'
                    ]
                ],
                'testimonial_text' => [
                    'name' => 'Testimonial',
                    'type' => 'textarea',
                    'required' => true,
                    'order' => 2,
                    'options' => [
                        'rows' => 6,
                        'placeholder' => 'Customer testimonial...'
                    ]
                ],
                'rating' => [
                    'name' => 'Rating',
                    'type' => 'number',
                    'required' => true,
                    'order' => 3,
                    'options' => [
                        'min' => 1,
                        'max' => 5,
                        'step' => 1
                    ]
                ],
                'company' => [
                    'name' => 'Company',
                    'type' => 'text',
                    'required' => false,
                    'order' => 4,
                    'options' => [
                        'placeholder' => 'Company name'
                    ]
                ],
                'position' => [
                    'name' => 'Position',
                    'type' => 'text',
                    'required' => false,
                    'order' => 5,
                    'options' => [
                        'placeholder' => 'Job title'
                    ]
                ],
                'customer_image' => [
                    'name' => 'Customer Image',
                    'type' => 'file',
                    'required' => false,
                    'order' => 6,
                    'options' => [
                        'allowed_types' => ['jpg', 'png', 'gif'],
                        'max_size' => '5MB'
                    ]
                ],
                'is_featured' => [
                    'name' => 'Featured Testimonial',
                    'type' => 'checkbox',
                    'required' => false,
                    'order' => 7,
                    'options' => [
                        'default' => false
                    ]
                ]
            ]
        ];
        
        // Update each content type with fields
        foreach ($contentTypeFields as $name => $fields) {
            $contentType = ContentType::where('name', $name)->first();
            
            if ($contentType) {
                echo "Updating {$contentType->name} with " . count($fields) . " fields...\n";
                
                $contentType->update([
                    'fields_schema' => $fields
                ]);
                
                echo "✅ {$contentType->name} updated successfully!\n";
            } else {
                echo "❌ Content type with name '{$name}' not found!\n";
            }
        }
        
        echo "\n🎉 Content Types fields seeding completed!\n";
    }
}
