@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Financial Transactions</h1>
            <p class="index-subtitle">Track barangay income and payment records</p>
        </div>
        <a href="{{ route('transaction_details.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Transaction
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $transaction_details->count() }}</div>
                <div class="stat-label">Total Transactions</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₱{{ number_format($transaction_details->sum('amount'), 2) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">₱{{ number_format($transaction_details->avg('amount'), 2) }}</div>
                <div class="stat-label">Average Amount</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $all_trand->where('status.description', 'Pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <div class="filter-group">
            <label class="filter-label">Filter by Date:</label>
            <input type="date" id="filterDate" class="filter-input" placeholder="Filter by date">
        </div>
        <div class="filter-group">
            <label class="filter-label">Filter by Type:</label>
            <select id="filterType" class="filter-select">
                <option value="">All Types</option>
                @foreach($transaction_types as $type)
                    <option value="{{ $type->name }}">{{ $type->description }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Filter by Status:</label>
            <select id="filterStatus" class="filter-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->name }}">{{ $status->description }}</option>
                @endforeach
            </select>
        </div>
        <button id="clearFilters" class="clear-filters-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
            Clear
        </button>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header-actions">
            <div class="table-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                </svg>
                <span>Transaction Records</span>
            </div>
            <div class="table-info">
                Showing <span id="visibleCount">{{ $transaction_details->count() }}</span> of {{ $transaction_details->count() }} transactions
            </div>
        </div>
        <div class="table-wrapper">
            <table class="data-table" id="transactionsTable">
                <thead>
                    <tr>
                        <th>Transaction Type</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Transaction Date</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaction_details as $t)
                    <tr class="transaction-row">
                        <td class="type-cell">
                            <span class="type-badge">
                                {{ $t->transactionType->description ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="method-cell">
                            <div class="method-info">
                                <span>{{ $t->paymentMethod->method ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="amount-cell">
                            <span class="amount-badge">
                                ₱{{ number_format($t->amount, 2) }}
                            </span>
                        </td>
                        <td class="status-cell">
                            <span class="status-badge">
                                {{ $t->status->description }}
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
                                {{ \Carbon\Carbon::parse($t->transaction_date)->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="actions">
                            <div class="actions-container">
                                <a href="{{ route('transaction_details.edit', $t->id) }}" class="action-btn edit-btn" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form
                                    action="{{ route('transaction_details.destroy', $t->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    onsubmit="openDeleteModal(event, this, '{{ $t->transactionType->description ?? 'N/A' }} that value at ₱{{ number_format($t->amount, 2) }} on {{ \Carbon\Carbon::parse($t->transaction_date)->format('M d, Y') }}')"
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
                        <td colspan="7" class="empty-state">
                            <div class="empty-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                                </svg>
                            </div>
                            <p>No transactions found</p>
                            <a href="{{ route('transaction_details.create') }}" class="btn-create-sm">Add your first transaction</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                {{ $transaction_details->links() }}
            </div>
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

    * {
        box-sizing: border-box;
    }

    body {
        background: var(--background-color);
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
        margin: 0;
    }

    .index-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    /* CREATE BUTTON */
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
        color: #B88900;
    }

    .stat-icon.warning {
        background: rgba(245, 158, 11, 0.15);
        color: #D97706;
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

    /* FILTERS */
    .filters-container {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: flex-end;

        background: #ffffff;
        padding: 18px;
        border-radius: 14px;

        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);

        margin-bottom: 24px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 200px;
        flex: 1;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input,
    .filter-select {
        height: 44px;
        padding: 0 14px;

        border: 1px solid #D1D5DB;
        border-radius: 10px;

        background: #ffffff;
        color: #1F2937;

        font-size: 0.9rem;
        font-weight: 500;

        outline: none;
        transition: all 0.2s ease;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: #0038A8;
        box-shadow: 0 0 0 4px rgba(0, 56, 168, 0.1);
    }

    .clear-filters-btn {
        height: 44px;

        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 0 16px;

        border: none;
        border-radius: 10px;

        background: rgba(220, 38, 38, 0.1);
        color: #DC2626;

        font-size: 0.85rem;
        font-weight: 600;

        cursor: pointer;
        transition: all 0.2s ease;
    }

    .clear-filters-btn:hover {
        background: rgba(220, 38, 38, 0.18);
        transform: translateY(-1px);
    }

    /* TABLE */
    .table-container {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.06);

        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;

        padding: 18px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }

    .table-title {
        display: flex;
        align-items: center;
        gap: 8px;

        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
    }

    .table-info {
        font-size: 0.85rem;
        color: #6B7280;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
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
        white-space: nowrap;
    }

    .data-table td {
        padding: 16px 18px;
        border-top: 1px solid rgba(0,0,0,0.05);
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
    }

    /* TYPE */
    .type-badge {
        display: inline-block;
        padding: 6px 12px;

        background: rgba(0, 56, 168, 0.1);
        color: #0038A8;

        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* METHOD */
    .method-info {
        display: flex;
        align-items: center;
        gap: 8px;

        font-weight: 700;
        color: #374151;
    }

    /* AMOUNT */
    .amount-badge {
        font-weight: 700;
        color: #16A34A;
        font-size: 0.92rem;
    }

    /* STATUS */
    .status-badge {
        display: inline-flex;
        align-items: center;

        padding: 5px 10px;
        border-radius: 999px;

        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-pending {
        background: rgba(245, 158, 11, 0.12);
        color: #D97706;
    }

    .status-completed {
        background: rgba(22, 163, 74, 0.12);
        color: #15803D;
    }

    .status-failed {
        background: rgba(220, 38, 38, 0.12);
        color: #DC2626;
    }

    .status-default {
        background: rgba(107, 114, 128, 0.12);
        color: #4B5563;
    }

    /* DATE */
    .date-info {
        display: flex;
        align-items: center;
        gap: 6px;

        color: #4B5563;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    /* REF */
    .ref-badge {
        display: inline-block;

        padding: 4px 10px;
        border-radius: 999px;

        background: #F3F4F6;
        color: #374151;

        font-size: 0.75rem;
        font-weight: 700;
    }

    /* ACTIONS */
    .actions-col {
        width: 180px;
    }

    .actions-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        padding: 8px 12px;
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

    .empty-icon {
        margin-bottom: 12px;
        opacity: 0.6;
    }

    .btn-create-sm {
        display: inline-block;
        margin-top: 12px;

        background: linear-gradient(135deg, #0038A8, #CE1126);
        color: #ffffff;

        padding: 10px 16px;
        border-radius: 10px;

        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* UTILITIES */
    .hidden-row {
        display: none !important;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .index-container {
            padding: 16px;
        }

        .index-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .filters-container {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            min-width: 100%;
        }

        .table-header-actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .actions-container {
            flex-direction: column;
            width: 100%;
        }

        .action-btn {
            width: 100%;
        }
    }
</style>

<script>
    // Filter functionality
    function filterTransactions() {
        const dateFilter = document.getElementById('filterDate').value;
        const typeFilter = document.getElementById('filterType').value.toLowerCase();
        const statusFilter = document.getElementById('filterStatus').value.toLowerCase();
        const rows = document.querySelectorAll('.transaction-row');
        let visibleCount = 0;

        rows.forEach(row => {
            let show = true;

            if (dateFilter) {
                const dateCell = row.querySelector('.date-cell .date-info span')?.textContent || '';
                const rowDate = new Date(dateCell);
                const filterDateObj = new Date(dateFilter);
                if (rowDate.toDateString() !== filterDateObj.toDateString()) {
                    show = false;
                }
            }

            if (show && typeFilter) {
                const typeCell = row.querySelector('.type-cell .type-badge')?.textContent.toLowerCase() || '';
                if (!typeCell.includes(typeFilter)) {
                    show = false;
                }
            }

            if (show && statusFilter) {
                const statusCell = row.querySelector('.status-cell .status-badge')?.textContent.toLowerCase() || '';
                if (!statusCell.includes(statusFilter)) {
                    show = false;
                }
            }

            if (show) {
                row.classList.remove('hidden-row');
                visibleCount++;
            } else {
                row.classList.add('hidden-row');
            }
        });

        document.getElementById('visibleCount').textContent = visibleCount;
    }

    document.getElementById('filterDate').addEventListener('change', filterTransactions);
    document.getElementById('filterType').addEventListener('change', filterTransactions);
    document.getElementById('filterStatus').addEventListener('change', filterTransactions);

    document.getElementById('clearFilters').addEventListener('click', function() {
        document.getElementById('filterDate').value = '';
        document.getElementById('filterType').value = '';
        document.getElementById('filterStatus').value = '';
        document.querySelectorAll('.transaction-row').forEach(row => {
            row.classList.remove('hidden-row');
        });
        document.getElementById('visibleCount').textContent = document.querySelectorAll('.transaction-row').length;
    });
</script>
@endsection
