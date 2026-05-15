@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Complaint Details</h1>
            <p class="index-subtitle">Manage and track barangay complaints</p>
        </div>
        <a href="{{ route('complaint_details.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Complaint
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
                <div class="stat-value">{{ $complaint_details->count() }}</div>
                <div class="stat-label">Total Complaints</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">
                    {{ $complaint_details->filter(fn($v) => ($v->status->description ?? '') === 'Pending')->count() }}
                </div>
                <div class="stat-label">Pending</div>
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
                    {{ $all_compd
                    ->filter(fn($v) =>
                        in_array($v->status->description ?? '', ['Done', 'Resolved'])
                    )
                    ->count() }}
                </div>
                <div class="stat-label">Resolved</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $complaint_details->groupBy('complaint_type_id')->count() }}</div>
                <div class="stat-label">Complaint Types</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Complainant</th>
                    <th>Accused</th>
                    <th>Complaint Type</th>
                    <th>Status</th>
                    <th>Filed Date</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaint_details as $cd)
                <tr>
                    <td class="complainant-cell">
                        <div class="person-info">
                            <div>
                                <div class="person-name">
                                    {{ $cd->complainant->lastname ?? 'N/A' }}, {{ $cd->complainant->firstname ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="accused-cell">
                        <div class="person-info">
                            <div>
                                <div class="person-name">
                                    {{ $cd->accused->lastname ?? 'N/A' }}, {{ $cd->accused->firstname ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="type-badge">
                            {{ $cd->complaintType->description ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge">
                            {{ $cd->status->description  }}
                        </span>
                    </td>
                    <td>
                        <span class="date-text">
                            {{ $cd->created_at ? $cd->created_at->format('M d, Y') : 'N/A' }}
                        </span>
                    </td>
                    <td class="actions">
                        <a href="{{ route('complaint_details.edit', $cd->id) }}" class="action-btn edit-btn" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                            Edit
                        </a>
                        <form
                            action="{{ route('complaint_details.destroy', $cd->id) }}"
                            method="POST"
                            class="delete-form"
                            onsubmit="openDeleteModal(event, this, '{{ $cd->complainant->firstname }} {{ $cd->complainant->lastname }} complaint against {{ $cd->accused->firstname }} {{ $cd->accused->lastname }}')"
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
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <div class="empty-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p>No complaints found</p>
                        <a href="{{ route('complaint_details.create') }}" class="btn-create-sm">File your first complaint</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $complaint_details->links() }}
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

    /* ================= CREATE BUTTON ================= */

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);

        background: linear-gradient(
            135deg,
            var(--primary-color),
            var(--secondary-color)
        );

        color: white;
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

    .stat-icon.warning {
        background: rgba(252, 209, 22, 0.25);
        color: var(--accent-color);
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

    .data-table thead {
        background: var(--background-color);
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

    .actions-container {
        display: flex;
        justify-content: center;
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

        transition: 0.2s ease;
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
    }
</style>
@endsection
