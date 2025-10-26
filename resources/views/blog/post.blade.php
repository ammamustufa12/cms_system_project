@extends('layouts.app')

@section('title', $post->title ?? 'Blog Post')

@section('content')
<div class="container-fluid" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="row">
        <div class="col-lg-8">
            <!-- Blog Post Content -->
            <article class="blog-post">
                <!-- Post Header -->
                <header class="post-header mb-4">
                    <div class="post-meta mb-3">
                        <span class="post-category">
                            <i class="ri-price-tag-3-line me-1"></i>
                            <a href="/blog/category/{{ $post->category_slug ?? 'uncategorized' }}" 
                               class="text-decoration-none">
                                {{ $post->category_name ?? 'Uncategorized' }}
                            </a>
                        </span>
                        <span class="post-date ms-3">
                            <i class="ri-calendar-line me-1"></i>
                            {{ \Carbon\Carbon::parse($post->created_at ?? now())->format('M d, Y') }}
                        </span>
                        <span class="post-author ms-3">
                            <i class="ri-user-line me-1"></i>
                            {{ $post->author ?? 'Admin' }}
                        </span>
                    </div>
                    
                    <h1 class="post-title">{{ $post->title ?? 'Blog Post Title' }}</h1>
                    
                    @if($post->excerpt ?? false)
                    <div class="post-excerpt lead text-muted">
                        {{ $post->excerpt }}
                    </div>
                    @endif
                </header>

                <!-- Featured Image -->
                @if($post->featured_image ?? false)
                <div class="post-featured-image mb-4">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="img-fluid rounded">
                </div>
                @endif

                <!-- Post Content -->
                <div class="post-content">
                    {!! $post->content ?? '<p>No content available.</p>' !!}
                </div>

                <!-- Post Tags -->
                @if($post->tags ?? false)
                <div class="post-tags mt-4">
                    <h6>Tags:</h6>
                    @foreach(explode(',', $post->tags) as $tag)
                    <span class="badge bg-secondary me-2 mb-2">{{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif

                <!-- Post Footer -->
                <footer class="post-footer mt-5 pt-4 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="post-share">
                                <h6>Share this post:</h6>
                                <div class="social-share">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                                       target="_blank" class="btn btn-outline-primary btn-sm me-2">
                                        <i class="ri-facebook-line"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $post->title }}" 
                                       target="_blank" class="btn btn-outline-info btn-sm me-2">
                                        <i class="ri-twitter-line"></i> Twitter
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" 
                                       target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="ri-linkedin-line"></i> LinkedIn
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="post-actions">
                                <a href="/admin/posts" class="btn btn-outline-secondary btn-sm">
                                    <i class="ri-edit-line me-1"></i> Edit Post
                                </a>
                            </div>
                        </div>
                    </div>
                </footer>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="blog-sidebar">
                <!-- Search Widget -->
                <div class="widget mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Search Posts</h5>
                        </div>
                        <div class="card-body">
                            <form action="/blog/search" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" placeholder="Search...">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ri-search-line"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Categories Widget -->
                <div class="widget mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Categories</h5>
                        </div>
                        <div class="card-body">
                            <div class="category-list" id="categoriesList">
                                <!-- Categories will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts Widget -->
                <div class="widget mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Posts</h5>
                        </div>
                        <div class="card-body">
                            <div class="recent-posts" id="recentPosts">
                                <!-- Recent posts will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags Widget -->
                <div class="widget mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Popular Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="tag-cloud" id="tagCloud">
                                <!-- Tags will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Blog Post Styles */
.blog-post {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
}

.post-header {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 20px;
}

.post-meta {
    color: #6c757d;
    font-size: 0.9rem;
}

.post-meta a {
    color: #007bff;
    text-decoration: none;
}

.post-meta a:hover {
    text-decoration: underline;
}

.post-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    line-height: 1.2;
    margin-bottom: 20px;
}

.post-excerpt {
    font-size: 1.1rem;
    line-height: 1.6;
}

.post-featured-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 8px;
}

.post-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: #333;
}

.post-content p {
    margin-bottom: 1.5rem;
}

.post-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 20px;
    margin: 2rem 0;
    font-style: italic;
    color: #6c757d;
}

.post-content code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}

.post-content pre {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 2rem 0;
}

.post-content ul, .post-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.post-content li {
    margin-bottom: 0.5rem;
}

.post-tags .badge {
    font-size: 0.8rem;
    padding: 6px 12px;
}

.post-footer {
    background: #f8f9fa;
    margin: 0 -40px -40px -40px;
    padding: 30px 40px;
    border-radius: 0 0 12px 12px;
}

/* Sidebar Styles */
.blog-sidebar .card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.blog-sidebar .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    font-weight: 600;
}

.widget {
    margin-bottom: 30px;
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    margin-bottom: 10px;
}

.category-list a {
    color: #333;
    text-decoration: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.category-list a:hover {
    color: #007bff;
}

.category-list .badge {
    background: #e3f2fd;
    color: #1976d2;
    font-size: 0.75rem;
}

.recent-posts {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-post-item {
    display: flex;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f1f3f4;
}

.recent-post-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.recent-post-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 15px;
}

.recent-post-content h6 {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 5px;
    line-height: 1.3;
}

.recent-post-content a {
    color: #333;
    text-decoration: none;
}

.recent-post-content a:hover {
    color: #007bff;
}

.recent-post-meta {
    font-size: 0.8rem;
    color: #6c757d;
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-cloud .badge {
    font-size: 0.8rem;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tag-cloud .badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Social Share Buttons */
.social-share .btn {
    margin-bottom: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-post {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .post-title {
        font-size: 2rem;
    }
    
    .post-featured-image img {
        height: 250px;
    }
    
    .post-footer {
        margin: 0 -20px -20px -20px;
        padding: 20px;
    }
    
    .blog-sidebar {
        margin-top: 30px;
    }
}

/* Loading Animation */
.loading {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
// Blog Post Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    loadSidebarContent();
});

function loadSidebarContent() {
    loadCategories();
    loadRecentPosts();
    loadPopularTags();
}

function loadCategories() {
    const categories = JSON.parse(localStorage.getItem('blogCategories') || '[]');
    const categoriesList = document.getElementById('categoriesList');
    
    if (categories.length === 0) {
        categoriesList.innerHTML = '<p class="text-muted">No categories available</p>';
        return;
    }
    
    categoriesList.innerHTML = categories.map(category => `
        <li>
            <a href="/blog/category/${category.slug}">
                <i class="${category.icon} me-2" style="color: ${category.color}"></i>
                ${category.name}
                <span class="badge">${category.posts_count || 0}</span>
            </a>
        </li>
    `).join('');
}

function loadRecentPosts() {
    const posts = JSON.parse(localStorage.getItem('blogPosts') || '[]');
    const recentPosts = document.getElementById('recentPosts');
    
    if (posts.length === 0) {
        recentPosts.innerHTML = '<p class="text-muted">No recent posts</p>';
        return;
    }
    
    const recentPostsList = posts
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, 5);
    
    recentPosts.innerHTML = recentPostsList.map(post => `
        <div class="recent-post-item">
            <img src="${post.featured_image || '/images/no-image.jpg'}" 
                 alt="${post.title}" class="recent-post-image">
            <div class="recent-post-content">
                <h6><a href="/blog/post/${post.slug}">${post.title}</a></h6>
                <div class="recent-post-meta">
                    ${formatDate(post.created_at)}
                </div>
            </div>
        </div>
    `).join('');
}

function loadPopularTags() {
    const posts = JSON.parse(localStorage.getItem('blogPosts') || '[]');
    const tagCloud = document.getElementById('tagCloud');
    
    if (posts.length === 0) {
        tagCloud.innerHTML = '<p class="text-muted">No tags available</p>';
        return;
    }
    
    // Collect all tags
    const allTags = [];
    posts.forEach(post => {
        if (post.tags) {
            post.tags.forEach(tag => {
                allTags.push(tag.trim());
            });
        }
    });
    
    // Count tag frequency
    const tagCounts = {};
    allTags.forEach(tag => {
        tagCounts[tag] = (tagCounts[tag] || 0) + 1;
    });
    
    // Sort by frequency and get top 10
    const popularTags = Object.entries(tagCounts)
        .sort(([,a], [,b]) => b - a)
        .slice(0, 10)
        .map(([tag, count]) => ({ tag, count }));
    
    if (popularTags.length === 0) {
        tagCloud.innerHTML = '<p class="text-muted">No tags available</p>';
        return;
    }
    
    tagCloud.innerHTML = popularTags.map(({ tag, count }) => `
        <span class="badge bg-secondary" onclick="searchByTag('${tag}')">
            ${tag} (${count})
        </span>
    `).join('');
}

function searchByTag(tag) {
    window.location.href = `/blog/search?tag=${encodeURIComponent(tag)}`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}
</script>
@endsection
