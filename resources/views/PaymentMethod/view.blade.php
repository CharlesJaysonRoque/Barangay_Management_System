@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Payment Methods</h1>
            <p class="index-subtitle">Manage payment options for barangay transactions</p>
        </div>
        <a href="{{ route('payment_methods.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Method
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                    <circle cx="7" cy="15" r="1.5" fill="currentColor"/>
                    <circle cx="17" cy="15" r="1.5" fill="currentColor"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $payment_methods->count() }}</div>
                <div class="stat-label">Total Methods</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4v16h16V4H4zm2 2h12v2H6V6zm0 4h12v2H6v-2zm0 4h12v2H6v-2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $payment_methods->count() }}</div>
                <div class="stat-label">Active Methods</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">Payment Method</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payment_methods as $payment_method)
                @php
                    $hasTransactions = \App\Models\TransactionDetail::where('payment_method_id', $payment_method->id)->count();
                @endphp
                <tr>
                    <td class="text-center">
                        <div class="method-info">
                            <div class="method-icon">
                                @php
                                    $methodLower = strtolower($payment_method->method);
                                @endphp
                                @if(str_contains($methodLower, 'cash'))
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v12M6 12h12"/>
                                    </svg>
                                @elseif(str_contains($methodLower, 'card') || str_contains($methodLower, 'credit') || str_contains($methodLower, 'debit'))
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                        <line x1="1" y1="10" x2="23" y2="10"/>
                                    </svg>
                                @elseif(str_contains($methodLower, 'gcash') || str_contains($methodLower, 'paymaya') || str_contains($methodLower, 'digital'))
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 12H18l-2 4-4-8-2 8-2-4H2"/>
                                    </svg>
                                @elseif(str_contains($methodLower, 'bank') || str_contains($methodLower, 'transfer'))
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 10h18M6 10v8h12v-8M12 4l8 6H4l8-6z"/>
                                    </svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 10H21M7 15h1m4 0h1m4 0h1M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                                    </svg>
                                @endif
                            </div>
                            <span class="method-name">{{ $payment_method->method }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="status-badge active">Active</span>
                    </td>
                    <td class="text-center">
                        <span class="date-text">
                            {{ $payment_method->created_at ? $payment_method->created_at->format('M d, Y') : 'N/A' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="actions-container">
                            <a href="{{ route('payment_methods.edit', $payment_method->id) }}" class="action-btn edit-btn" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                                Edit
                            </a>
                            @if($hasTransactions > 0)
                            <div class="warning-tooltip">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="tooltip-text">Cannot delete - has assigned transaction(s)</span>
                            </div>
                            @else
                            <form
                                action="{{ route('payment_methods.destroy', $payment_method->id) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="openDeleteModal(event, this, '{{ $payment_method->method }} Method')"
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
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <div class="empty-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                        </div>
                        <p>No payment methods found</p>
                        <a href="{{ route('payment_methods.create') }}" class="btn-create-sm">Add your first payment method</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $payment_methods->links() }}
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
