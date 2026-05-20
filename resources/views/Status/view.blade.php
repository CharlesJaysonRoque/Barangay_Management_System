@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">System Statuses</h1>
            <p class="index-subtitle">Manage status types for complaints and projects</p>
        </div>
        <a href="{{ route('statuses.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Status
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $statuses->count() }}</div>
                <div class="stat-label">Total Statuses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $statuses->whereIn('description', ['Completed', 'Resolved', 'Approved'])->count() }}</div>
                <div class="stat-label">Completed/Resolved</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $statuses->whereIn('description', ['Pending', 'Ongoing', 'In Progress'])->count() }}</div>
                <div class="stat-label">Pending/Active</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header-actions">
            <div class="table-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Status Definitions</span>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Used In</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statuses as $status)
                    @php
                        $usedInComplaints = \App\Models\ComplaintDetail::where('status_id', $status->id)->count();
                        $usedInProjects = \App\Models\ProjectDetail::where('status_id', $status->id)->count();
                        $totalUsage = $usedInComplaints + $usedInProjects;

                        // Determine status type and color
                        $statusDesc = strtolower($status->description);
                        if(str_contains($statusDesc, 'complete') || str_contains($statusDesc, 'resolved') || str_contains($statusDesc, 'approved') || str_contains($statusDesc, 'done')) {
                            $statusType = 'success';
                            $typeLabel = 'Completed';
                        } elseif(str_contains($statusDesc, 'pending') || str_contains($statusDesc, 'open') || str_contains($statusDesc, 'progress') || str_contains($statusDesc, 'ongoing')) {
                            $statusType = 'warning';
                            $typeLabel = 'Active';
                        } elseif(str_contains($statusDesc, 'cancelled') || str_contains($statusDesc, 'rejected') || str_contains($statusDesc, 'closed')) {
                            $statusType = 'danger';
                            $typeLabel = 'Closed';
                        } else {
                            $statusType = 'info';
                            $typeLabel = 'Other';
                        }
                    @endphp
                    <tr>
                        <td class="status-cell">
                            <div class="status-info">
                                <div class="status-indicator status-{{ $statusType }}"></div>
                                <div>
                                    <div class="status-name">{{ $status->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="type-cell">
                            <span class="type-badge type-{{ $statusType }}">
                                {{ $typeLabel }}
                            </span>
                        </td>
                        <td class="usage-cell">
                            <div class="usage-stats">
                                @if($usedInComplaints > 0)
                                    <span class="usage-badge complaints">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $usedInComplaints }} complaint(s)
                                    </span>
                                @endif
                                @if($usedInProjects > 0)
                                    <span class="usage-badge projects">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                        </svg>
                                        {{ $usedInProjects }} project(s)
                                    </span>
                                @endif
                                @if($totalUsage === 0)
                                    <span class="usage-badge none">Not used yet</span>
                                @endif
                            </div>
                        </td>
                        <td class="actions">
                            <div class="actions-container">
                                <a href="{{ route('statuses.edit', $status->id) }}" class="action-btn edit-btn" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                            @if($totalUsage === 0)
                                <form
                                    action="{{ route('statuses.destroy', $status->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    onsubmit="openDeleteModal(event, this, '{{ $status->description }} Status')"
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
                            @if($totalUsage > 0)
                                <div class="warning-tooltip">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span class="tooltip-text">Cannot delete - in use</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <div class="empty-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                            </div>
                            <p>No statuses found</p>
                            <a href="{{ route('statuses.create') }}" class="btn-create-sm">Create your first status</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                {{ $statuses->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .index-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* HEADER */
    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 32px;
    }

    .index-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1F2937;
        letter-spacing: -0.5px;
    }

    .index-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    /* CREATE BUTTON (FIXED + CLEAN) */
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        background: linear-gradient(135deg, #0038A8, #CE1126);
        color: #ffffff;

        padding: 12px 18px;
        border-radius: 12px;

        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;

        box-shadow: 0 6px 18px rgba(0, 56, 168, 0.25);

        transition: all 0.25s ease;
        border: none;
        cursor: pointer;
    }

    .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 56, 168, 0.3);
    }

    /* STATS */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px;

        display: flex;
        align-items: center;
        gap: 14px;

        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);

        transition: all 0.25s ease;
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
        color: #0038A8;
    }

    .stat-icon.success {
        background: rgba(22, 163, 74, 0.12);
        color: #16A34A;
    }

    .stat-icon.warning {
        background: rgba(252, 209, 22, 0.15);
        color: #FCD116;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1F2937;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* TABLE */
    .table-container {
        background: #ffffff;
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
        background: #F8FAFC;
    }

    .data-table th {
        padding: 16px 18px;
        text-align: left;

        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;

        color: #6B7280;
        letter-spacing: 0.5px;
    }

    .data-table td {
        padding: 16px 18px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .data-table tbody tr {
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
    }

    /* BADGE */
    .type-badge {
        display: inline-block;
        padding: 4px 10px;

        background: rgba(0, 56, 168, 0.1);
        color: #0038A8;

        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* OFFICIAL */
    .official-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .official-avatar {
        width: 38px;
        height: 38px;

        background: linear-gradient(135deg, #0038A8, #CE1126);
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #fff;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .official-name {
        font-weight: 600;
        color: #1F2937;
    }

    .official-email {
        font-size: 0.75rem;
        color: #6B7280;
    }

    /* ACTIONS */
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

        transition: all 0.2s ease;
    }

    .edit-btn {
        background: rgba(0, 56, 168, 0.1);
        color: #0038A8;
    }

    .edit-btn:hover {
        background: rgba(0, 56, 168, 0.2);
        transform: translateY(-1px);
    }

    .delete-btn {
        background: rgba(220, 38, 38, 0.1);
        color: #DC2626;
    }

    .delete-btn:hover {
        background: rgba(220, 38, 38, 0.2);
        transform: translateY(-1px);
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 3rem !important;
        color: #6B7280;
    }

    /* RESPONSIVE */
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
