<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        //Admin
        "admin/login",
        "admin/update-admin-details",
        "admin/update-admin-password",
        "admin/check-admin-password",
        "admin/admins/{type?}",
        "admin/update-admin-status",
        //section
        "admin/sections",
        "admin/add-edit-section",
        "admin/add-edit-section/{id?}",
        "admin/delete-section/{id}",
        "admin/update-section-status",
        //authors
        "admin/authors",
        "admin/update-author-status",    
        "admin/delete-author/{id}",    
        "admin/add-edit-author",
        "admin/add-edit-author/{id?}",
        //categories
        "admin/categories",
        "admin/add-edit-category",
        "admin/update-category-status",
        "admin/add-edit-category/{id?}",
        //sub categories
        "admin/append-categories-level",  
        "admin/delete-category/{id}",
        "admin/delete-category-image/{id}",  
        //products
        "admin/products",
        "admin/add-edit-product",
        "admin/update-product-status",
        "admin/delete-product/{id}",
        "admin/add-edit-product/{id?}",
        "admin/delete-product-image/{id}",
        "admin/delete-product-video/{id}",
        //Attributes
        "admin/add-edit-attributes/{id}",
        "admin/update-attribute-status",
        "admin/delete-attribute/{id}",
        "admin/edit-attributes/{id}",
        //filters
        "admin/filters",
        "admin/add-edit-filter",
        "admin/filters-values",
        "admin/add-edit-filter-value",
        "admin/update-filter-status",
        "admin/update-filter-value-status",
        "admin/add-edit-filter/{id?}",
        "admin/add-edit-filter-value/{id?}",
        "admin/category-filters",
        "admin/add-images/{id}",
        "admin/update-image-status",
        "admin/delete-image/{id}",
        //banners or ads
        "admin/banners",
        "admin/update-banner-status",
        "admin/delete-banner/{id}",
        "admin/add-edit-banner",
        "admin/add-edit-banner/{id?}",
        "admin/update-user-status",
        "admin/users",
        "admin/logout",

        //Users
        "user/login-register",

        //Vendor
        "vendor/register",
        "admin/update-vendor-details/{slug}",
        "admin/view-vendor-details/{id}"
        
    ];
}
