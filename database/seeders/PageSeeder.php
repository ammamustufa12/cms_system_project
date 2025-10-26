<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'content' => '<h1>Welcome to Our Website</h1><p>This is the homepage of our website. Here you can find information about our company, services, and latest updates.</p><p>We are committed to providing the best experience for our visitors and customers.</p>',
                'excerpt' => 'Welcome to our website. Discover our services and latest updates.',
                'meta_title' => 'Home - Welcome to Our Website',
                'meta_description' => 'Welcome to our website. Discover our services, company information, and latest updates.',
                'status' => 'published',
                'is_homepage' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h1>About Our Company</h1><p>We are a leading company in our industry, dedicated to providing exceptional services and solutions to our clients.</p><h2>Our Mission</h2><p>To deliver innovative solutions that help our clients achieve their goals and grow their businesses.</p><h2>Our Vision</h2><p>To be the most trusted partner for businesses worldwide.</p>',
                'excerpt' => 'Learn more about our company, mission, and vision.',
                'meta_title' => 'About Us - Our Company Story',
                'meta_description' => 'Learn about our company, mission, vision, and the team behind our success.',
                'status' => 'published',
                'is_homepage' => false,
                'sort_order' => 2,
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'content' => '<h1>Our Services</h1><p>We offer a wide range of services to meet your business needs:</p><ul><li><strong>Web Development</strong> - Custom websites and web applications</li><li><strong>Mobile App Development</strong> - iOS and Android applications</li><li><strong>Digital Marketing</strong> - SEO, social media, and content marketing</li><li><strong>Consulting</strong> - Business strategy and technology consulting</li></ul>',
                'excerpt' => 'Discover our comprehensive range of services including web development, mobile apps, and digital marketing.',
                'meta_title' => 'Services - What We Offer',
                'meta_description' => 'Explore our comprehensive services including web development, mobile apps, digital marketing, and consulting.',
                'status' => 'published',
                'is_homepage' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => '<h1>Get in Touch</h1><p>We would love to hear from you. Contact us using any of the methods below:</p><h2>Contact Information</h2><ul><li><strong>Email:</strong> info@company.com</li><li><strong>Phone:</strong> +1 (555) 123-4567</li><li><strong>Address:</strong> 123 Business Street, City, State 12345</li></ul><h2>Business Hours</h2><p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>',
                'excerpt' => 'Get in touch with us. Find our contact information and business hours.',
                'meta_title' => 'Contact Us - Get in Touch',
                'meta_description' => 'Contact us for inquiries, support, or business opportunities. Find our contact information and business hours.',
                'status' => 'published',
                'is_homepage' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'Blog',
                'slug' => 'blog',
                'content' => '<h1>Our Blog</h1><p>Stay updated with our latest news, insights, and industry trends.</p><p>Our blog covers topics related to technology, business, marketing, and more.</p><h2>Recent Posts</h2><p>Check back soon for our latest blog posts!</p>',
                'excerpt' => 'Read our latest blog posts about technology, business, and industry insights.',
                'meta_title' => 'Blog - Latest News and Insights',
                'meta_description' => 'Read our blog for the latest news, insights, and trends in technology and business.',
                'status' => 'published',
                'is_homepage' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>This privacy policy explains how we collect, use, and protect your personal information.</p><h2>Information We Collect</h2><p>We collect information you provide directly to us, such as when you create an account or contact us.</p><h2>How We Use Your Information</h2><p>We use the information we collect to provide, maintain, and improve our services.</p>',
                'excerpt' => 'Learn about how we collect, use, and protect your personal information.',
                'meta_title' => 'Privacy Policy - Data Protection',
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal information.',
                'status' => 'published',
                'is_homepage' => false,
                'sort_order' => 6,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h1>Terms of Service</h1><p>These terms of service govern your use of our website and services.</p><h2>Acceptance of Terms</h2><p>By accessing and using our website, you accept and agree to be bound by the terms and provision of this agreement.</p><h2>Use License</h2><p>Permission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only.</p>',
                'excerpt' => 'Read our terms of service that govern your use of our website and services.',
                'meta_title' => 'Terms of Service - Legal Terms',
                'meta_description' => 'Read our terms of service that govern your use of our website and services.',
                'status' => 'published',
                'is_homepage' => false,
                'sort_order' => 7,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        echo "✅ Pages seeded successfully!\n";
        echo "Created " . count($pages) . " sample pages.\n";
    }
}