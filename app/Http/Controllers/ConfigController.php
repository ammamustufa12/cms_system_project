<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        return view('vendor.twill.config');
    }

    // System Settings
    public function globalConfiguration()
    {
        return view('vendor.twill.config.global-configuration');
    }

    public function yourCompany()
    {
        return view('vendor.twill.config.your-company');
    }

    public function userManagement()
    {
        return view('vendor.twill.config.user-management');
    }

    public function categoryManagement()
    {
        return view('vendor.twill.config.category-management');
    }

    // Admin Template
    public function templateStructure()
    {
        return view('vendor.twill.config.template-structure');
    }

    public function design()
    {
        return view('vendor.twill.config.design');
    }

    public function theme()
    {
        return view('vendor.twill.config.theme');
    }

    public function components()
    {
        return view('vendor.twill.config.components');
    }

    public function widgets()
    {
        return view('vendor.twill.config.widgets');
    }

    public function forms()
    {
        return view('vendor.twill.config.forms');
    }

    public function tables()
    {
        return view('vendor.twill.config.tables');
    }

    public function charts()
    {
        return view('vendor.twill.config.charts');
    }

    public function icons()
    {
        return view('vendor.twill.config.icons');
    }

    public function maps()
    {
        return view('vendor.twill.config.maps');
    }

    // Admin Menu Management
    public function adminMenuManagement()
    {
        return view('vendor.twill.config.admin-menu-management');
    }

    // Category Management
    public function categoryManagementSettings()
    {
        return view('vendor.twill.config.category-management-settings');
    }
}

