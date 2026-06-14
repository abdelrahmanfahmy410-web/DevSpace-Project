{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.admin')
@php
    $pageTitle    = 'Dashboard';
    $pageSubtitle = 'Platform overview';
@endphp


@section('content')
    {{-- Stats Grid --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:var(--space-4); margin-bottom:var(--space-6);">

        <div class="card" style="padding:var(--space-4) var(--space-5);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:var(--space-3);">
                <span class="text-label">Total Users</span>
                <div
                    style="width:36px;height:36px;border-radius:50%;background:var(--color-primary-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-users" style="color:var(--color-primary);font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:28px;font-weight:var(--font-weight-bold);color:var(--color-dark-navy);line-height:1;">
                {{ number_format($stats['total_users']) }}
            </div>
        </div>

        <div class="card" style="padding:var(--space-4) var(--space-5);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:var(--space-3);">
                <span class="text-label">Total Projects</span>
                <div
                    style="width:36px;height:36px;border-radius:50%;background:var(--color-stage-proto);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-diagram-project" style="color:var(--color-stage-proto-text);font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:28px;font-weight:var(--font-weight-bold);color:var(--color-dark-navy);line-height:1;">
                {{ number_format($stats['total_projects']) }}
            </div>
        </div>

        <div class="card" style="padding:var(--space-4) var(--space-5);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:var(--space-3);">
                <span class="text-label">New This Month</span>
                <div
                    style="width:36px;height:36px;border-radius:50%;background:var(--color-warning-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-plus" style="color:var(--color-warning-text);font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:28px;font-weight:var(--font-weight-bold);color:var(--color-dark-navy);line-height:1;">
                {{ number_format($stats['new_this_month']) }}
            </div>
        </div>

        <div class="card" style="padding:var(--space-4) var(--space-5);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:var(--space-3);">
                <span class="text-label">Specializations</span>
                <div
                    style="width:36px;height:36px;border-radius:50%;background:var(--color-primary-bg);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-layer-group" style="color:var(--color-primary);font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:28px;font-weight:var(--font-weight-bold);color:var(--color-dark-navy);line-height:1;">
                {{ number_format($stats['total_specializations']) }}
            </div>
        </div>

    </div>

    {{-- Role Breakdown + Top Projects --}}
    <div style="display:grid; grid-template-columns:1fr 1.6fr; gap:var(--space-5); margin-bottom:var(--space-5);">

        <div class="card" style="padding:var(--space-5);">
            <h3 class="heading-3" style="margin-bottom:var(--space-4);">Users by Role</h3>
            <div style="display:flex; flex-direction:column; gap:var(--space-3);">
                @foreach ($stats['users_by_role'] as $role)
                    <div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                            <span
                                style="font-size:var(--font-size-small);font-weight:var(--font-weight-medium);text-transform:capitalize;">{{ $role->role_name ?? 'Unknown' }}</span>
                            <span
                                style="font-size:var(--font-size-small);color:var(--color-muted);">{{ $role->total }}</span>
                        </div>
                        <div
                            style="height:6px;background:var(--color-bg-light);border-radius:var(--radius-pill);overflow:hidden;">
                            <div
                                style="height:100%;width:{{ $stats['total_users'] > 0 ? round(($role->total / $stats['total_users']) * 100) : 0 }}%;background:var(--color-primary);border-radius:var(--radius-pill);">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card" style="padding:var(--space-5);">
            <h3 class="heading-3" style="margin-bottom:var(--space-4);">Most Viewed Projects</h3>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--color-border);">
                        <th
                            style="text-align:left;font-size:var(--font-size-meta);font-weight:var(--font-weight-medium);color:var(--color-muted);padding-bottom:var(--space-2);text-transform:uppercase;letter-spacing:0.05em;">
                            Project</th>
                        <th
                            style="text-align:right;font-size:var(--font-size-meta);font-weight:var(--font-weight-medium);color:var(--color-muted);padding-bottom:var(--space-2);text-transform:uppercase;letter-spacing:0.05em;">
                            Views</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['top_projects'] as $project)
                        <tr style="border-bottom:1px solid var(--color-border);">
                            <td
                                style="padding:var(--space-3) 0;font-size:var(--font-size-small);font-weight:var(--font-weight-medium);">
                                {{ $project->title }}</td>
                            <td style="padding:var(--space-3) 0;text-align:right;">
                                <span class="badge badge--grey">{{ number_format($project->views) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2"
                                style="padding:var(--space-4) 0;color:var(--color-muted);font-size:var(--font-size-small);text-align:center;">
                                No projects yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Signups Over Time --}}
    <div class="card" style="padding:var(--space-5);">
        <h3 class="heading-3" style="margin-bottom:var(--space-4);">Signups — Last 6 Months</h3>
        <div style="display:flex; align-items:flex-end; gap:var(--space-3); height:120px;">
            @php $maxSignups = $stats['signups_by_month']->max('total') ?: 1; @endphp
            @foreach ($stats['signups_by_month'] as $month)
                <div
                    style="flex:1; display:flex; flex-direction:column; align-items:center; gap:var(--space-2); height:100%;">
                    <span style="font-size:11px;color:var(--color-muted);">{{ $month->total }}</span>
                    <div
                        style="width:100%;background:var(--color-primary);border-radius:var(--radius-sm) var(--radius-sm) 0 0;height:{{ round(($month->total / $maxSignups) * 80) }}px;min-height:4px;">
                    </div>
                    <span style="font-size:11px;color:var(--color-muted);white-space:nowrap;">{{ $month->month }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
