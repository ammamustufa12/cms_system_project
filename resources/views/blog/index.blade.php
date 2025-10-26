@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<div class="container-fluid" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="row">
        <div class="col-lg-8">
            <!-- Blog Header -->
            <div class="blog-header mb-5">
                <h1 class="blog-title">Our Blog</h1>
                <p class="blog-subtitle">Stay updated with the latest articles, tutorials, and insights</p>
            </div>

            <!-- Featured Post -->
            <div class="featured-post mb-5" id="featuredPost">
                <!-- Featured post will be loaded here -->
            </div>

            <!-- Blog Posts Grid -->
            <div class="blog-posts" id="blogPosts">
                <!-- Posts will be loaded here -->
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-5">
                <button class="btn btn-primary btn-lg" onclick="loadMorePosts()" id="loadMoreBtn">
                    <i class="ri-refresh-line me-2"></i>Load More Posts
                </button>
            </div>
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
                            <form onsubmit="searchPosts(event)">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
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
/* Blog Index Styles */
.blog-header {
    text-align: center;
    padding: 40px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    margin-bottom: 40px;
}

.blog-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.blog-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 0;
}

/* Featured Post Styles */
.featured-post {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.featured-post:hover {
    transform: translateY(-5px);
}

.featured-post-image {
    height: 300px;
    background-size: cover;
    background-position: center;
    position: relative;
}

.featured-post-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 30px;
}

.featured-post-content {
    padding: 30px;
}

.featured-post-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #333;
}

.featured-post-excerpt {
    font-size: 1.1rem;
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
}

.featured-post-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    font-size: 0.9rem;
    color: #6c757d;
}

/* Blog Posts Grid */
.blog-posts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.post-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.post-image {
    height: 200px;
    background-size: cover;
    background-position: center;
    position: relative;
}

.post-category-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.post-content {
    padding: 25px;
}

.post-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
    line-height: 1.4;
}

.post-excerpt {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #6c757d;
}

.post-date {
    display: flex;
    align-items: center;
    gap: 5px;
}

.post-author {
    display: flex;
    align-items: center;
    gap: 5px;
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
    transition: color 0.3s ease;
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

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h5 {
    margin-bottom: 10px;
    color: #495057;
}

.empty-state p {
    margin-bottom: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-title {
        font-size: 2rem;
    }
    
    .blog-posts {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .featured-post-title {
        font-size: 1.5rem;
    }
    
    .blog-sidebar {
        margin-top: 30px;
    }
}
</style>

<script>
// Blog Index JavaScript
let allPosts = [];
let displayedPosts = [];
let currentPage = 1;
let postsPerPage = 6;
let currentSearch = '';

document.addEventListener('DOMContentLoaded', function() {
    loadBlogData();
});

function loadBlogData() {
    loadPosts();
    loadCategories();
    loadRecentPosts();
    loadPopularTags();
}

function loadPosts() {
    // Load posts from localStorage
    const savedPosts = localStorage.getItem('blogPosts');
    if (savedPosts) {
        allPosts = JSON.parse(savedPosts);
    } else {
        // Sample posts
        allPosts = [
            {
                id: 1,
                title: 'Getting Started with Web Development',
                slug: 'getting-started-web-development',
                content: 'Web development is an exciting field that combines creativity with technical skills...',
                excerpt: 'Learn the basics of web development and start your journey as a developer.',
                author: 'Admin',
                category_id: 1,
                category_name: 'Web Development',
                status: 'published',
                featured_image: '/images/sample-post-1.jpg',
                tags: ['web development', 'programming', 'tutorial'],
                is_featured: true,
                created_at: '2024-01-15'
            },
            {
                id: 2,
                title: 'Advanced JavaScript Techniques',
                slug: 'advanced-javascript-techniques',
                content: 'JavaScript is a powerful programming language that continues to evolve...',
                excerpt: 'Explore advanced JavaScript concepts and modern development practices.',
                author: 'Admin',
                category_id: 2,
                category_name: 'JavaScript',
                status: 'published',
                featured_image: '/images/sample-post-2.jpg',
                tags: ['javascript', 'programming', 'advanced'],
                is_featured: false,
                created_at: '2024-01-20'
            },
            {
                id: 3,
                title: 'CSS Grid vs Flexbox: Which to Use?',
                slug: 'css-grid-vs-flexbox',
                content: 'Both CSS Grid and Flexbox are powerful layout systems...',
                excerpt: 'A comprehensive comparison of CSS Grid and Flexbox layout systems.',
                author: 'Admin',
                category_id: 1,
                category_name: 'Web Development',
                status: 'published',
                featured_image: '/images/sample-post-3.jpg',
                tags: ['css', 'layout', 'web design'],
                is_featured: false,
                created_at: '2024-01-25'
            }
        ];
    }
    
    renderPosts();
}

function renderPosts() {
    const publishedPosts = allPosts.filter(post => post.status === 'published');
    const featuredPost = publishedPosts.find(post => post.is_featured);
    const regularPosts = publishedPosts.filter(post => !post.is_featured);
    
    // Render featured post
    renderFeaturedPost(featuredPost);
    
    // Render regular posts
    renderPostsGrid(regularPosts.slice(0, postsPerPage));
    
    // Update load more button
    updateLoadMoreButton(regularPosts.length);
}

function renderFeaturedPost(post) {
    const featuredContainer = document.getElementById('featuredPost');
    
    if (!post) {
        featuredContainer.innerHTML = '';
        return;
    }
    
    featuredContainer.innerHTML = `
        <div class="featured-post" onclick="viewPost('${post.slug}')">
            <div class="featured-post-image" style="background-image: url('${post.featured_image || '/images/no-image.jpg'}')">
                <div class="featured-post-overlay">
                    <div class="featured-post-meta">
                        <span class="post-category">
                            <i class="ri-price-tag-3-line me-1"></i>
                            ${post.category_name || 'Uncategorized'}
                        </span>
                        <span class="post-date">
                            <i class="ri-calendar-line me-1"></i>
                            ${formatDate(post.created_at)}
                        </span>
                        <span class="post-author">
                            <i class="ri-user-line me-1"></i>
                            ${post.author}
                        </span>
                    </div>
                </div>
            </div>
            <div class="featured-post-content">
                <h2 class="featured-post-title">${post.title}</h2>
                <p class="featured-post-excerpt">${post.excerpt || 'No excerpt available'}</p>
                <a href="/blog/post/${post.slug}" class="btn btn-primary">
                    Read More <i class="ri-arrow-right-line ms-1"></i>
                </a>
            </div>
        </div>
    `;
}

function renderPostsGrid(posts) {
    const postsContainer = document.getElementById('blogPosts');
    
    if (posts.length === 0) {
        postsContainer.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="ri-article-line"></i>
                    <h5>No posts found</h5>
                    <p>Check back later for new content.</p>
                </div>
            </div>
        `;
        return;
    }
    
    postsContainer.innerHTML = posts.map(post => `
        <div class="post-card" onclick="viewPost('${post.slug}')">
            <div class="post-image" style="background-image: url('${post.featured_image || '/images/no-image.jpg'}')">
                <div class="post-category-badge">${post.category_name || 'Uncategorized'}</div>
            </div>
            <div class="post-content">
                <h3 class="post-title">${post.title}</h3>
                <p class="post-excerpt">${post.excerpt || 'No excerpt available'}</p>
                <div class="post-meta">
                    <span class="post-date">
                        <i class="ri-calendar-line me-1"></i>
                        ${formatDate(post.created_at)}
                    </span>
                    <span class="post-author">
                        <i class="ri-user-line me-1"></i>
                        ${post.author}
                    </span>
                </div>
            </div>
        </div>
    `).join('');
}

function loadMorePosts() {
    const publishedPosts = allPosts.filter(post => post.status === 'published' && !post.is_featured);
    const startIndex = currentPage * postsPerPage;
    const endIndex = startIndex + postsPerPage;
    const morePosts = publishedPosts.slice(startIndex, endIndex);
    
    if (morePosts.length === 0) {
        document.getElementById('loadMoreBtn').style.display = 'none';
        return;
    }
    
    const postsContainer = document.getElementById('blogPosts');
    const newPostsHTML = morePosts.map(post => `
        <div class="post-card" onclick="viewPost('${post.slug}')">
            <div class="post-image" style="background-image: url('${post.featured_image || '/images/no-image.jpg'}')">
                <div class="post-category-badge">${post.category_name || 'Uncategorized'}</div>
            </div>
            <div class="post-content">
                <h3 class="post-title">${post.title}</h3>
                <p class="post-excerpt">${post.excerpt || 'No excerpt available'}</p>
                <div class="post-meta">
                    <span class="post-date">
                        <i class="ri-calendar-line me-1"></i>
                        ${formatDate(post.created_at)}
                    </span>
                    <span class="post-author">
                        <i class="ri-user-line me-1"></i>
                        ${post.author}
                    </span>
                </div>
            </div>
        </div>
    `).join('');
    
    postsContainer.insertAdjacentHTML('beforeend', newPostsHTML);
    currentPage++;
    
    if (endIndex >= publishedPosts.length) {
        document.getElementById('loadMoreBtn').style.display = 'none';
    }
}

function updateLoadMoreButton(totalPosts) {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (totalPosts <= postsPerPage) {
        loadMoreBtn.style.display = 'none';
    } else {
        loadMoreBtn.style.display = 'block';
    }
}

function searchPosts(event) {
    event.preventDefault();
    const searchTerm = document.getElementById('searchInput').value;
    currentSearch = searchTerm;
    
    if (!searchTerm.trim()) {
        renderPosts();
        return;
    }
    
    const filteredPosts = allPosts.filter(post => 
        post.status === 'published' &&
        (post.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
         post.content.toLowerCase().includes(searchTerm.toLowerCase()) ||
         post.excerpt.toLowerCase().includes(searchTerm.toLowerCase()))
    );
    
    renderSearchResults(filteredPosts);
}

function renderSearchResults(posts) {
    const postsContainer = document.getElementById('blogPosts');
    document.getElementById('featuredPost').innerHTML = '';
    
    if (posts.length === 0) {
        postsContainer.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <i class="ri-search-line"></i>
                    <h5>No posts found</h5>
                    <p>Try adjusting your search terms.</p>
                </div>
            </div>
        `;
        return;
    }
    
    renderPostsGrid(posts);
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
    const posts = allPosts
        .filter(post => post.status === 'published')
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, 5);
    
    const recentPosts = document.getElementById('recentPosts');
    
    if (posts.length === 0) {
        recentPosts.innerHTML = '<p class="text-muted">No recent posts</p>';
        return;
    }
    
    recentPosts.innerHTML = posts.map(post => `
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
    const posts = allPosts.filter(post => post.status === 'published');
    
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
    
    const tagCloud = document.getElementById('tagCloud');
    
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
    document.getElementById('searchInput').value = tag;
    searchPosts({ preventDefault: () => {} });
}

function viewPost(slug) {
    window.location.href = `/blog/post/${slug}`;
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
