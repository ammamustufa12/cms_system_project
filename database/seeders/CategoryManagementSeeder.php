<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryGroup;
use App\Models\Category;

class CategoryManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Category Groups
        $productGroup = CategoryGroup::create([
            'name' => 'Product Categories',
            'description' => 'Categories for organizing products',
            'slug' => 'product-categories',
            'is_active' => true,
            'sort_order' => 1,
            'color' => '#007bff',
            'icon' => 'ri-shopping-bag-line'
        ]);

        $blogGroup = CategoryGroup::create([
            'name' => 'Blog Categories',
            'description' => 'Categories for organizing blog posts',
            'slug' => 'blog-categories',
            'is_active' => true,
            'sort_order' => 2,
            'color' => '#28a745',
            'icon' => 'ri-article-line'
        ]);

        $serviceGroup = CategoryGroup::create([
            'name' => 'Service Categories',
            'description' => 'Categories for organizing services',
            'slug' => 'service-categories',
            'is_active' => true,
            'sort_order' => 3,
            'color' => '#ffc107',
            'icon' => 'ri-service-line'
        ]);

        // Create Product Categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and gadgets',
            'slug' => 'electronics',
            'category_group_id' => $productGroup->id,
            'is_active' => true,
            'sort_order' => 1,
            'color' => '#007bff',
            'icon' => 'ri-smartphone-line',
            'meta_title' => 'Electronics - Latest Electronic Devices',
            'meta_description' => 'Shop the latest electronic devices and gadgets at our store.',
            'meta_keywords' => 'electronics, gadgets, devices, technology'
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'description' => 'Fashion and apparel',
            'slug' => 'clothing',
            'category_group_id' => $productGroup->id,
            'is_active' => true,
            'sort_order' => 2,
            'color' => '#e83e8c',
            'icon' => 'ri-shirt-line',
            'meta_title' => 'Clothing - Fashion & Apparel',
            'meta_description' => 'Discover the latest fashion trends and clothing collections.',
            'meta_keywords' => 'clothing, fashion, apparel, style'
        ]);

        // Create subcategories for Electronics
        Category::create([
            'name' => 'Smartphones',
            'description' => 'Mobile phones and accessories',
            'slug' => 'smartphones',
            'category_group_id' => $productGroup->id,
            'parent_id' => $electronics->id,
            'is_active' => true,
            'sort_order' => 1,
            'color' => '#007bff',
            'icon' => 'ri-smartphone-line'
        ]);

        Category::create([
            'name' => 'Laptops',
            'description' => 'Portable computers and accessories',
            'slug' => 'laptops',
            'category_group_id' => $productGroup->id,
            'parent_id' => $electronics->id,
            'is_active' => true,
            'sort_order' => 2,
            'color' => '#007bff',
            'icon' => 'ri-computer-line'
        ]);

        // Create subcategories for Clothing
        Category::create([
            'name' => 'Men\'s Clothing',
            'description' => 'Men\'s fashion and apparel',
            'slug' => 'mens-clothing',
            'category_group_id' => $productGroup->id,
            'parent_id' => $clothing->id,
            'is_active' => true,
            'sort_order' => 1,
            'color' => '#e83e8c',
            'icon' => 'ri-user-line'
        ]);

        Category::create([
            'name' => 'Women\'s Clothing',
            'description' => 'Women\'s fashion and apparel',
            'slug' => 'womens-clothing',
            'category_group_id' => $productGroup->id,
            'parent_id' => $clothing->id,
            'is_active' => true,
            'sort_order' => 2,
            'color' => '#e83e8c',
            'icon' => 'ri-women-line'
        ]);

        // Create Blog Categories
        Category::create([
            'name' => 'Technology',
            'description' => 'Technology news and articles',
            'slug' => 'technology',
            'category_group_id' => $blogGroup->id,
            'is_active' => true,
            'sort_order' => 1,
            'color' => '#28a745',
            'icon' => 'ri-computer-line'
        ]);

        Category::create([
            'name' => 'Lifestyle',
            'description' => 'Lifestyle and wellness articles',
            'slug' => 'lifestyle',
            'category_group_id' => $blogGroup->id,
            'is_active' => true,
            'sort_order' => 2,
            'color' => '#28a745',
            'icon' => 'ri-heart-line'
        ]);

        // Create Service Categories
        Category::create([
            'name' => 'Web Development',
            'description' => 'Website and web application development services',
            'slug' => 'web-development',
            'category_group_id' => $serviceGroup->id,
            'is_active' => true,
            'sort_order' => 1,
            'color' => '#ffc107',
            'icon' => 'ri-code-line'
        ]);

        Category::create([
            'name' => 'Digital Marketing',
            'description' => 'Online marketing and advertising services',
            'slug' => 'digital-marketing',
            'category_group_id' => $serviceGroup->id,
            'is_active' => true,
            'sort_order' => 2,
            'color' => '#ffc107',
            'icon' => 'ri-marketing-line'
        ]);
    }
}