@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Transaction Types</h1>
            <p class="index-subtitle">Manage categories for barangay financial transactions</p>
        </div>
        <a href="{{ route('transaction_types.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Transaction Type
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $transaction_types->count() }}</div>
                <div class="stat-label">Total Types</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\TransactionDetail::count() }}</div>
                <div class="stat-label">Total Transactions</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₱{{ number_format(\App\Models\TransactionDetail::sum('amount'), 2) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header-actions">
            <div class="table-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                </svg>
                <span>Transaction Categories</span>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Transaction Type</th>
                        <th>Transactions Count</th>
                        <th>Total Revenue</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaction_types as $type)
                    @php
                        $transactionCount = \App\Models\TransactionDetail::where('transaction_type_id', $type->id)->count();
                        $totalAmount = \App\Models\TransactionDetail::where('transaction_type_id', $type->id)->sum('amount');

                        // Determine type icon based on description
                        $typeLower = strtolower($type->description);
                        if(str_contains($typeLower, 'clearance')) {
                            $icon = '📋';
                        } elseif(str_contains($typeLower, 'permit')) {
                            $icon = '📄';
                        } elseif(str_contains($typeLower, 'tax')) {
                            $icon = '🏛️';
                        } elseif(str_contains($typeLower, 'fee')) {
                            $icon = '💰';
                        } elseif(str_contains($typeLower, 'donation')) {
                            $icon = '🎁';
                        } elseif(str_contains($typeLower, 'rent')) {
                            $icon = '🏘️';
                        } else {
                            $icon = '💵';
                        }
                    @endphp
                    <tr>
                        <td class="type-cell">
                            <div class="type-info">
                                <span class="type-icon">{{ $icon }}</span>
                                <div>
                                    <div class="type-name">{{ $type->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="count-cell">
                            @if($transactionCount > 0)
                                <a href="{{ route('transaction_details.index') }}?type={{ $type->id }}" class="count-link">
                                    <span class="count-badge {{ $transactionCount > 10 ? 'high' : ($transactionCount > 0 ? 'medium' : 'low') }}">
                                        {{ $transactionCount }} transaction(s)
                                    </span>
                                </a>
                            @else
                                <span class="count-badge zero">No transactions</span>
                            @endif
                        </td>
                        <td class="amount-cell">
                            @if($totalAmount > 0)
                                <span class="amount-badge">
                                    ₱{{ number_format($totalAmount, 2) }}
                                </span>
                            @else
                                <span class="amount-badge zero">₱0.00</span>
                            @endif
                        </td>
                        <td class="status-cell">
                            @if($transactionCount > 0)
                                <span class="status-badge active">Active</span>
                            @else
                                <span class="status-badge inactive">Unused</span>
                            @endif
                        </td>
                        <td class="date-cell">
                            <span class="date-text">
                                {{ $type->created_at ? $type->created_at->format('M d, Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="actions">
                            <div class="actions-container">
                                <a href="{{ route('transaction_types.edit', $type->id) }}" class="action-btn edit-btn" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                @if($transactionCount == 0)
                                <form
                                    action="{{ route('transaction_types.destroy', $type->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    onsubmit="openDeleteModal(event, this, '{{ $type->description }}')"
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
                            @if($transactionCount > 0)
                                <div class="warning-tooltip">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span class="tooltip-text">Cannot delete - has transactions</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <div class="empty-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                                </svg>
                            </div>
                            <p>No transaction types found</p>
                            <a href="{{ route('transaction_types.create') }}" class="btn-create-sm">Create your first transaction type</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    :root {
            /* Main Theme Colors - Philippine Flag */
            --primary-color: #0038A8;      /* Philippine blue */
            --secondary-color: #CE1126;    /* Philippine red */
            --accent-color: #FCD116;       /* Gold / yellow */

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
            --radius-2xl: 1.5rem;
            --radius-3xl: 2rem;

            /* Transitions */
            --transition-fast: 150ms ease;
            --transition-base: 250ms ease;
        }
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

    .stat-icon.accent {
        background: rgba(252, 209, 22, 0.25);
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
