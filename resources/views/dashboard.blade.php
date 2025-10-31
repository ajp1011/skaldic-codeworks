@extends('layouts.authenticated')

@section('title', 'Dashboard - Skaldic Codeworks')
@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-grid">
    <div class="welcome-card">
        <h3 class="welcome-title">Welcome back, {{ auth()->user()->name ?? 'User' }}!</h3>
        <p class="welcome-subtitle">Explore the available modules and services below.</p>
    </div>
    
    <!-- API Control Panel Module -->
    <div class="module-card">
        <div class="module-header">
            <div class="module-icon module-icon-blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="module-title">API Control Panel</h3>
        </div>
        <div class="module-content">
            <p class="module-description">
                Administrator interface for managing and interacting with AWS console services. 
                Provides secure access to cloud resources, monitoring, and configuration management.
            </p>
            <div class="module-status">
                <span class="status-badge status-coming-soon">Coming Soon</span>
            </div>
        </div>
    </div>
    
    <!-- Multimedia Player Module -->
    <div class="module-card">
        <div class="module-header">
            <div class="module-icon module-icon-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="module-title">Multimedia Player</h3>
        </div>
        <div class="module-content">
            <p class="module-description">
                Rich media playback system with support for video and audio formats. 
                Features playlist management, streaming capabilities, and media library organization.
            </p>
            <div class="module-status">
                <span class="status-badge status-coming-soon">Coming Soon</span>
            </div>
        </div>
    </div>
    
    <!-- Reporting Service Module -->
    <div class="module-card">
        <div class="module-header">
            <div class="module-icon module-icon-purple">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="module-title">Reporting Service</h3>
        </div>
        <div class="module-content">
            <p class="module-description">
                Comprehensive reporting and analytics platform with customizable dashboards. 
                Generate reports in multiple formats with scheduled delivery and data visualization.
            </p>
            <div class="module-status">
                <span class="status-badge status-coming-soon">Coming Soon</span>
            </div>
        </div>
    </div>
    
    <!-- CRM/Ticketing System Module -->
    <div class="module-card">
        <div class="module-header">
            <div class="module-icon module-icon-orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <h3 class="module-title">CRM/Ticketing System</h3>
        </div>
        <div class="module-content">
            <p class="module-description">
                Customer relationship management and support ticketing system designed for landlords and tenants. 
                Manage properties, handle maintenance requests, and maintain communication logs.
            </p>
            <div class="module-status">
                <span class="status-badge status-coming-soon">Coming Soon</span>
            </div>
        </div>
    </div>
</div>
@endsection
