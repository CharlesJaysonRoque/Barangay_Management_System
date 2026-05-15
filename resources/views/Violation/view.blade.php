@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Violations & Penalties</h1>
            <p class="index-subtitle">Track resident violations and imposed fines</p>
        </div>
        <a href="{{ route('violations.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Violation
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
                <div class="stat-value">{{ $violations->count() }}</div>
                <div class="stat-label">Total Violations</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">
                    {{ $violations->filter(fn($v) => ($v->status->description ?? '') === 'Pending')->count() }}
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
                    {{ $violations->filter(fn($v) => ($v->status->description ?? '') === 'Done')->count() }}
                </div>
                <div class="stat-label">Paid/Resolved</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₱{{ number_format($violations->sum('fine.amount'), 2) }}</div>
                <div class="stat-label">Total Fines</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header-actions">
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Resident</th>
                        <th>Violation</th>
                        <th>Fine Amount</th>
                        <th>Status</th>
                        <th>Date Issued</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($violations as $violation)
                    <tr>
                        <td class="resident-cell">
                            <div class="resident-info">
                                <div>
                                    <div class="resident-name">
                                        {{ $violation->resident->lastname ?? 'N/A' }}, {{ $violation->resident->firstname ?? 'N/A' }}
                                    </div>
                                    <div class="resident-details">
                                        {{ $violation->resident->contact_number ?? 'No contact' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="violation-cell">
                            <div class="violation-info">
                                <span class="violation-desc">{{ $violation->fine->description ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="amount-cell">
                            <span class="amount-badge">
                                ₱{{ number_format($violation->fine->amount ?? 0, 2) }}
                            </span>
                        </td>
                        <td class="status-cell">
                            <span class="status-badge">
                                {{ $violation->status->description  }}
                            </span>
                        </td>
                        <td class="date-cell">
                            <div class="date-info">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $violation->created_at ? $violation->created_at->format('M d, Y') : 'N/A' }}
                            </div>
                        </td>
                        <td class="actions">
                            <div class="actions-container">
                                <a href="{{ route('violations.edit', $violation->id) }}" class="action-btn edit-btn" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form
                                    action="{{ route('violations.destroy', $violation->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    onsubmit="openDeleteModal(event, this, ' this violation filled on {{ $violation->resident->lastname }}, {{ $violation->resident->firstname }} with a violation (of) {{ $violation->fine->description}}')"
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
                                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p>No violations found</p>
                            <a href="{{ route('violations.create') }}" class="btn-create-sm">Record your first violation</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                {{ $violations->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        /* Main Theme Colors */
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

        /* Reusable RGB */
        --primary-rgb: 0, 56, 168;
        --success-rgb: 22, 163, 74;
        --accent-rgb: 252, 209, 22;
        --danger-rgb: 220, 38, 38;

        /* Borders & Shadows */
        --border-color: #D1D5DB;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --shadow-lg: rgba(0, 0, 0, 0.15);

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
        --radius-2xl: 1.5rem;
        --radius-3xl: 2rem;

        /* Transitions */
        --transition-fast: 150ms ease;
        --transition-base: 250ms ease;
    }

    /* CONTAINER */
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
        color: var(--text-color);
        letter-spacing: -0.5px;
    }

    .index-subtitle {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-top: 4px;
    }

    /* CREATE BUTTON */
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
        font-size: 0.9rem;
        text-decoration: none;

        box-shadow: 0 6px 18px rgba(var(--primary-rgb), 0.25);

        transition: all var(--transition-base);
        border: none;
        cursor: pointer;
    }

    .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(var(--primary-rgb), 0.3);
    }

    /* STATS */
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

    .stat-icon.info {
        background: rgba(var(--primary-rgb), 0.12);
        color: var(--primary-color);
    }

    .stat-icon.success {
        background: rgba(var(--success-rgb), 0.12);
        color: var(--success-color);
    }

    .stat-icon.accent {
        background: rgba(var(--accent-rgb), 0.25);
        color: var(--accent-color);
    }

    .stat-icon.danger {
        background: rgba(var(--danger-rgb), 0.2);
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
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* TABLE */
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
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
    }

    /* BADGE */
    .type-badge {
        display: inline-block;
        padding: 4px 10px;

        background: rgba(var(--primary-rgb), 0.1);
        color: var(--primary-color);

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
        background: rgba(var(--primary-rgb), 0.1);
        color: var(--primary-color);
    }

    .edit-btn:hover {
        background: rgba(var(--primary-rgb), 0.2);
        transform: translateY(-1px);
    }

    .delete-btn {
        background: rgba(var(--danger-rgb), 0.1);
        color: var(--danger-color);
    }

    .delete-btn:hover {
        background: rgba(var(--danger-rgb), 0.2);
        transform: translateY(-1px);
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 3rem !important;
        color: var(--text-light);
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
