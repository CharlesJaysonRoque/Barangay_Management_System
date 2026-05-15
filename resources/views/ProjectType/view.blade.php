@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Project Types</h1>
            <p class="index-subtitle">Manage categories for barangay development projects</p>
        </div>
        <a href="{{ route('project_types.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Project Type
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $project_types->count() }}</div>
                <div class="stat-label">Total Types</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\ProjectDetail::count() }}</div>
                <div class="stat-label">Total Projects</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $project_types->whereIn('id', \App\Models\ProjectDetail::pluck('project_type_id'))->count() }}</div>
                <div class="stat-label">Active Types</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Project Type</th>
                    <th>Projects Count</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($project_types as $type)
                @php
                    $projectCount = \App\Models\ProjectDetail::where('project_type_id', $type->id)->count();
                @endphp
                <tr>
                    <td class="type-cell">
                        <div class="type-info">
                            <div class="type-icon">
                                @php
                                    $typeLower = strtolower($type->description);
                                    if(str_contains($typeLower, 'infra') || str_contains($typeLower, 'road') || str_contains($typeLower, 'bridge')) {
                                        $icon = '<path d="M3 12h18M3 6h18M3 18h18"/>';
                                    } elseif(str_contains($typeLower, 'health') || str_contains($typeLower, 'clinic')) {
                                        $icon = '<path d="M12 8v8m-4-4h8"/><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>';
                                    } elseif(str_contains($typeLower, 'educ') || str_contains($typeLower, 'school')) {
                                        $icon = '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>';
                                    } elseif(str_contains($typeLower, 'clean') || str_contains($typeLower, 'environment')) {
                                        $icon = '<path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
                                    } else {
                                        $icon = '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>';
                                    }
                                @endphp
                                {!! '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' . $icon . '</svg>' !!}
                            </div>
                            <div>
                                <div class="type-name">{{ $type->description }}</div>
                                <div class="type-details">ID: #{{ $type->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        @if($projectCount > 0)
                            <a href="{{ route('project_details.index') }}?type={{ $type->id }}" class="project-count-link">
                                <span class="count-badge {{ $projectCount > 5 ? 'high' : ($projectCount > 0 ? 'medium' : 'low') }}">
                                    {{ $projectCount }} {{ Str::plural('project(s) →', $projectCount) }}
                                </span>
                            </a>
                        @else
                            <span class="count-badge zero">No projects yet</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($projectCount > 0)
                            <span class="status-badge active">In Use</span>
                        @else
                            <span class="status-badge inactive">Unused</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="date-text">
                            {{ $type->created_at ? $type->created_at->format('M d, Y') : 'N/A' }}
                        </span>
                    </td>
                    <td class="actions">
                        <div class="actions-container">
                            <a href="{{ route('project_types.edit', $type->id) }}" class="action-btn edit-btn" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                                Edit
                            </a>
                            <form
                                action="{{ route('project_types.destroy', $type->id) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="openDeleteModal(event, this, '{{ $type->description }} type project')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-btn delete-btn" title="Delete">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                        @if($projectCount > 0)
                            <div class="warning-tooltip">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="tooltip-text">Cannot delete - has associated projects</span>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        <div class="empty-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <p>No project types found</p>
                        <a href="{{ route('project_types.create') }}" class="btn-create-sm">Create your first project type</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $project_types->links() }}
        </div>
    </div>
</div>

<style>
    :root {
        /* ================= COLORS ================= */

        /* Main Theme Colors - Philippine Flag */
        --primary-color: #0038A8;
        --secondary-color: #CE1126;
        --accent-color: #FCD116;

        /* Hover Colors */
        --primary-hover: #002d87;
        --secondary-hover: #a80e20;
        --accent-hover: #e0b800;

        /* Neutral Colors */
        --background-color: #F8FAFC;
        --surface-color: #FFFFFF;
        --text-color: #1F2937;
        --text-light: #6B7280;

        /* Status Colors */
        --success-color: #16A34A;
        --warning-color: #F59E0B;
        --danger-color: #DC2626;

        /* Borders & Shadows */
        --border-color: #D1D5DB;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --shadow-lg: rgba(0, 0, 0, 0.15);

        /* ================= SPACING ================= */

        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;

        /* ================= BORDER RADIUS ================= */

        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
        --radius-3xl: 2rem;
        --radius-full: 999px;

        /* ================= FONT SIZES ================= */

        --font-size-xs: 0.7rem;
        --font-size-sm: 0.85rem;
        --font-size-md: 1rem;
        --font-size-lg: 1.25rem;
        --font-size-xl: 1.5rem;
        --font-size-2xl: 2rem;

        /* ================= TRANSITIONS ================= */

        --transition-fast: 150ms ease;
        --transition-base: 250ms ease;
    }

    /* ================= PROJECT LINK ================= */

    .project-count-link {
        background: rgba(0, 56, 168, 0.15);
        color: var(--primary-color);
        padding: var(--spacing-sm);
        border-radius: var(--radius-lg);
    }

    /* ================= CONTAINER ================= */

    .index-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= HEADER ================= */

    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 32px;
    }

    .index-title {
        font-size: var(--font-size-2xl);
        font-weight: 800;
        color: var(--text-color);
        letter-spacing: -0.5px;
    }

    .index-subtitle {
        color: var(--text-light);
        font-size: var(--font-size-sm);
        margin-top: 4px;
    }

    /* ================= CREATE BUTTON ================= */

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        background: linear-gradient(
            135deg,
            var(--primary-color),
            var(--secondary-color)
        );

        color: var(--surface-color);

        padding: 12px 18px;
        border-radius: 12px;

        font-weight: 600;
        font-size: var(--font-size-sm);

        text-decoration: none;
        border: none;
        cursor: pointer;

        box-shadow: 0 6px 18px rgba(0, 56, 168, 0.25);

        transition: all var(--transition-base);
    }

    .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 56, 168, 0.3);
    }

    /* ================= STATS ================= */

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--surface-color);
        border-radius: 14px;
        padding: 18px;

        display: flex;
        align-items: center;
        gap: 14px;

        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);

        transition: all var(--transition-base);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .stat-icon {
        width: 46px;
        height: 46px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.primary {
        background: rgba(0, 56, 168, 0.12);
        color: var(--primary-color);
    }

    .stat-icon.success {
        background: rgba(22, 163, 74, 0.12);
        color: var(--success-color);
    }

    .stat-icon.accent {
        background: rgba(252, 209, 22, 0.25);
        color: var(--accent-color);
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-color);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ================= TABLE ================= */

    .table-container {
        background: var(--surface-color);
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.06);

        overflow-x: auto;

        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: var(--background-color);
    }

    .data-table th {
        padding: 16px 18px;
        text-align: left;

        font-size: 0.75rem;
        font-weight: 700;

        text-transform: uppercase;

        color: var(--text-light);
        letter-spacing: 0.5px;
    }

    .data-table td {
        padding: 16px 18px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .data-table tbody tr {
        transition: all var(--transition-fast);
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
    }

    /* ================= BADGES ================= */

    .type-badge {
        display: inline-block;

        padding: 4px 10px;

        background: rgba(252, 209, 22, 0.15);
        color: var(--accent-color);

        border-radius: var(--radius-full);

        font-size: 0.75rem;
        font-weight: 600;
    }

    /* ================= OFFICIAL INFO ================= */

    .official-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .official-avatar {
        width: 38px;
        height: 38px;

        background: linear-gradient(
            135deg,
            var(--primary-color),
            var(--secondary-color)
        );

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        color: var(--surface-color);

        font-weight: 700;
        font-size: 0.8rem;
    }

    .official-name {
        font-weight: 600;
        color: var(--text-color);
    }

    .official-email {
        font-size: 0.75rem;
        color: var(--text-light);
    }

    /* ================= ACTIONS ================= */

    .actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 10px;

        border-radius: 10px;

        font-size: 0.75rem;
        font-weight: 600;

        text-decoration: none;

        border: none;
        cursor: pointer;

        transition: all var(--transition-fast);
    }

    .edit-btn {
        background: rgba(0, 56, 168, 0.15);
        color: var(--primary-color);
    }

    .edit-btn:hover {
        background: rgba(0, 56, 168, 0.25);
        transform: translateY(-1px);
    }

    .delete-btn {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
    }

    .delete-btn:hover {
        background: rgba(220, 38, 38, 0.2);
        transform: translateY(-1px);
    }

    /* ================= EMPTY ================= */

    .empty-state {
        text-align: center;
        padding: 3rem !important;
        color: var(--text-light);
    }

    /* ================= RESPONSIVE ================= */

    @media (max-width: 768px) {

        .index-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .actions {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection
