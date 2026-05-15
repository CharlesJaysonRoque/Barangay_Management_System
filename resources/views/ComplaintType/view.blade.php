@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Complaint Types</h1>
            <p class="index-subtitle">Manage complaint categories for barangay incidents</p>
        </div>
        <a href="{{ route('complaint_types.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Complaint Type
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $complaint_types->count() }}</div>
                <div class="stat-label">Total Types</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\ComplaintDetail::count() }}</div>
                <div class="stat-label">Total Complaints</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">Description</th>
                    <th class="text-center">Complaints Count</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaint_types as $complaint_type)
                @php
                    $complaintCount = \App\Models\ComplaintDetail::where('complaint_type_id', $complaint_type->id)->count();
                @endphp
                <tr>
                    <td class="text-center">
                        <span class="type-badge">
                            {{ $complaint_type->description }}
                        </span>
                    </td>
                    <td class="text-center ">
                        @if($complaintCount > 0)
                            <a href="{{ route('complaint_details.index') }}?type={{ $complaint_type->id }}" class="complaint-count-link">
                                <span class="count-badge {{ $complaintCount > 5 ? 'high' : ($complaintCount > 0 ? 'medium' : 'low') }}">
                                    {{ $complaintCount }} complaint(s) →
                                </span>
                            </a>
                        @else
                            <span class="count-badge zero">No complaints yet</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($complaintCount > 0)
                            <span class="status-badge active">Active Type</span>
                        @else
                            <span class="status-badge inactive">Unused</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="actions-container">
                            <a href="{{ route('complaint_types.edit', $complaint_type->id) }}" class="action-btn edit-btn" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                                Edit
                            </a>
                            @if($complaintCount == 0)
                            <form
                                action="{{ route('complaint_types.destroy', $complaint_type->id) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="openDeleteModal(event, this, '{{ $complaint_type->description }}')"
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
                            @endif
                        </div>
                        @if($complaintCount > 0)
                            <div class="warning-tooltip">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="tooltip-text">Cannot delete - has active complaints</span>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <div class="empty-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p>No complaint types found</p>
                        <a href="{{ route('complaint_types.create') }}" class="btn-create-sm">Create your first complaint type</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $complaint_types->links() }}
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
        --border-color: #E5E7EB;

        --shadow-sm: 0 2px 6px rgba(0,0,0,0.08);
        --shadow-md: 0 6px 16px rgba(0,0,0,0.10);
        --shadow-lg: 0 12px 28px rgba(0,0,0,0.15);

        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;

        /* Radius */
        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;

        /* Transition */
        --transition-fast: 150ms ease;
        --transition-base: 250ms ease;
    }

    .status-badge.active {
        background: rgba(22, 163, 74, 0.12);
        color: var(--success-color);
        padding: var(--spacing-xs);
        border-radius: var(--radius-lg);
    }

    .status-badge.inactive {
        background: rgba(220, 38, 38, 0.12);
        color: var(--danger-color);
        padding: var(--spacing-xs);
        border-radius: var(--radius-lg);
    }
    /* ================= PAGE ================= */

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

        background: linear-gradient(
            135deg,
            var(--primary-color),
            var(--secondary-color)
        );

        color: var(--surface-color);

        padding: 0.75rem 1rem;
        border-radius: var(--radius-lg);

        font-weight: 600;
        text-decoration: none;

        box-shadow: var(--shadow-md);
        transition: var(--transition-base);
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

        transition: var(--transition-base);
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

    .stat-icon.danger {
        background: rgba(220, 38, 38, 0.12);
        color: var(--danger-color);
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-color);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-light);
    }

    .complaint-count-link {
        background: rgba(0, 56, 168, 0.1);
        color: var(--primary-color);
        padding: var(--spacing-sm);
        border-radius: var(--radius-lg);
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

    .data-table thead {
        background: var(--background-color);
    }

    .data-table th {
        padding: var(--spacing-md);
        text-align: left;

        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;

        color: var(--text-light);
    }

    .data-table td {
        padding: var(--spacing-md);
        border-top: 1px solid var(--border-color);
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
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

    /* ================= OFFICIAL ================= */

    .official-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .official-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;

        background: linear-gradient(
            135deg,
            var(--primary-color),
            var(--secondary-color)
        );

        display: flex;
        align-items: center;
        justify-content: center;

        color: white;
        font-weight: 700;
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
        border-radius: var(--radius-md);

        font-size: 0.75rem;
        font-weight: 600;

        border: none;
        cursor: pointer;
        text-decoration: none;

        transition: var(--transition-fast);
    }

    .edit-btn {
        background: rgba(0, 56, 168, 0.1);
        color: var(--primary-color);
    }

    .edit-btn:hover {
        background: rgba(0, 56, 168, 0.2);
    }

    .delete-btn {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
    }

    .delete-btn:hover {
        background: rgba(220, 38, 38, 0.2);
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
        }
    }
</style>
@endsection
