@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Barangay Projects</h1>
            <p class="index-subtitle">Manage infrastructure and community development projects</p>
        </div>
        <a href="{{ route('project_details.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Project
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
                <div class="stat-value">{{ $project_details->count() }}</div>
                <div class="stat-label">Total Projects</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">
                {{ $project_details
                ->filter(fn($v) =>
                    in_array($v->status->description ?? '', ['Pending', 'On Hold'])
                )
                ->count() }}
                </div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">
                {{ $project_details
                ->filter(fn($v) =>
                    in_array($v->status->description ?? '', ['Done'])
                )
                ->count() }}
                </div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₱{{ number_format($project_details->sum('budget'), 0) }}</div>
                <div class="stat-label">Total Budget</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Project Type</th>
                    <th>Description</th>
                    <th>Budget</th>
                    <th>Timeline</th>
                    <th>Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($project_details as $project)
                <tr>
                    <td class="type-cell">
                        <span class="type-badge">
                            {{ $project->projectType->description ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="description-cell">
                        <div class="description-text">
                            {{ Str::limit($project->description, 60) }}
                        </div>
                        @if($project->description && strlen($project->description) > 60)
                            <span class="read-more" onclick="this.parentElement.querySelector('.full-description').classList.toggle('hidden')">Read more</span>
                            <div class="full-description hidden">{{ $project->description }}</div>
                        @endif
                    </td>
                    <td class="budget-cell">
                        <span class="budget-amount">
                            ₱{{ number_format($project->budget, 2) }}
                        </span>
                    </td>
                    <td class="timeline-cell">
                        <div class="timeline-info">
                            <div class="timeline-item">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }}</span>
                            </div>
                            @if($project->actual_end_date)
                                <div class="timeline-item complete">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 6L9 17l-5-5"/>
                                    </svg>
                                    <span>Completed: {{ \Carbon\Carbon::parse($project->actual_end_date)->format('M d, Y') }}</span>
                                </div>
                            @elseif($project->tentative_end_date)
                                <div class="timeline-item tentative">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span>Est. completion: {{ \Carbon\Carbon::parse($project->tentative_end_date)->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                     </td>
                    <td class="status-cell">
                        <span class="status-badge">
                            {{ $project->status->description }}
                        </span>
                     </td>
                    <td class="actions">
                        <div class="actions-container">
                            <a href="{{ route('project_details.edit', $project->id) }}" class="action-btn edit-btn" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                                Edit
                            </a>
                            <form
                                action="{{ route('project_details.destroy', $project->id) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="openDeleteModal(event, this, '{{ $project->projectType->description }} for {{ $project->description }}')"
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
                     </td>
                 </tr>
                @empty
                 <tr>
                    <td colspan="6" class="empty-state">
                        <div class="empty-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <p>No projects found</p>
                        <a href="{{ route('project_details.create') }}" class="btn-create-sm">Create your first project</a>
                     </td>
                 </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $project_details->links() }}
        </div>
    </div>
</div>

<style>
    :root {
        /* Main Theme Colors - Philippine Flag */
        --primary-color: #0038A8;
        --secondary-color: #CE1126;
        --accent-color: #FCD116;

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

        --shadow-sm: 0 2px 6px rgba(0,0,0,0.08);
        --shadow-md: 0 6px 16px rgba(0,0,0,0.10);
        --shadow-lg: 0 12px 28px rgba(0,0,0,0.15);

        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;

        /* Border Radius */
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    /* ================= CONTAINER ================= */
    .index-container {
        padding: var(--spacing-xl);
        max-width: 1400px;
        margin: 0 auto;
        background: var(--background-color);
    }

    /* ================= HEADER ================= */
    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-xl);
    }

    .index-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-color);
    }

    .index-subtitle {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    /* ================= BUTTON ================= */
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);

        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;

        padding: 0.75rem 1rem;
        border-radius: var(--radius-lg);

        font-weight: 600;
        text-decoration: none;

        box-shadow: var(--shadow-md);
        transition: 0.25s ease;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* ================= STATS ================= */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-xl);
    }

    .stat-card {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--spacing-md);

        display: flex;
        align-items: center;
        gap: var(--spacing-md);

        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);

        transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: var(--radius-md);

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
        background: rgba(245, 158, 11, 0.15);
        color: var(--warning-color);
    }

    .stat-icon.danger {
        background: rgba(220, 38, 38, 0.12);
        color: var(--danger-color);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-color);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-light);
    }

    /* ================= TABLE ================= */
    .table-container {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        overflow-x: auto;
        box-shadow: var(--shadow-sm);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        padding: var(--spacing-md);
        text-transform: uppercase;
        font-size: 0.75rem;
        color: var(--text-light);
        font-weight: 700;
    }

    .data-table td {
        padding: var(--spacing-md);
        border-top: 1px solid var(--border-color);
    }

    .data-table tbody tr:hover {
        background: #EEF2FF;
    }

    /* ================= BADGE ================= */
    .type-badge {
        display: inline-block;
        padding: 4px 10px;
        background: rgba(0, 56, 168, 0.1);
        color: var(--primary-color);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* ================= ACTIONS ================= */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 10px;
        border-radius: var(--radius-md);

        font-size: 0.75rem;
        font-weight: 600;

        text-decoration: none;
        border: none;
        cursor: pointer;

        transition: 0.2s ease;
    }

    .edit-btn {
        background: rgba(0, 56, 168, 0.1);
        color: var(--primary-color);
    }

    .delete-btn {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
    }
</style>
@endsection
