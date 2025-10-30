@extends('layouts.authenticated')

@section('title', 'Dashboard - Skaldic Codeworks')
@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-grid">
    <div class="welcome-card">
        <h3 class="welcome-title">Welcome back, {{ auth()->user()->name ?? 'User' }}!</h3>
        <p class="welcome-subtitle">Here's what's happening with your account today.</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-info">
                <p class="stat-label">Total Projects</p>
                <p class="stat-value">12</p>
            </div>
            <div class="stat-icon stat-icon-blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-info">
                <p class="stat-label">Active Tasks</p>
                <p class="stat-value">8</p>
            </div>
            <div class="stat-icon stat-icon-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-info">
                <p class="stat-label">Completed</p>
                <p class="stat-value">24</p>
            </div>
            <div class="stat-icon stat-icon-purple">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="activity-card">
        <div class="card-header">
            <h3 class="card-title">Recent Activity</h3>
        </div>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon activity-icon-blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div class="activity-details">
                    <p class="activity-title">New project created</p>
                    <p class="activity-subtitle">Skaldic Codeworks Website</p>
                    <p class="activity-time">2 hours ago</p>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon activity-icon-green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="activity-details">
                    <p class="activity-title">Task completed</p>
                    <p class="activity-subtitle">Dashboard implementation</p>
                    <p class="activity-time">3 hours ago</p>
                </div>
            </div>
            
            <div class="activity-item">
                <div class="activity-icon activity-icon-purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <div class="activity-details">
                    <p class="activity-title">New comment added</p>
                    <p class="activity-subtitle">Authentication module review</p>
                    <p class="activity-time">5 hours ago</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="actions-card">
        <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
        </div>
        <div class="actions-list">
            <a href="{{ route('about') }}" class="action-button action-button-blue">
                <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                View Profile
            </a>
            
            <button class="action-button action-button-green">
                <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Project
            </button>
            
            <button class="action-button action-button-purple">
                <svg class="action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </button>
        </div>
    </div>
</div>
@endsection
