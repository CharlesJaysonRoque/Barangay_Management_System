@extends('admin.adminpage')

@section('adminContent')
<div class="edit-container">
    <div class="edit-card">
        <div class="edit-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10"/>
                </svg>
            </div>
            <div>
                <h1 class="edit-title">Edit Transaction</h1>
                <p class="edit-subtitle">Update transaction details</p>
            </div>
        </div>

        <form action="{{ route('transaction_details.update', $transaction_detail->id) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group half">
                    <label class="form-label">Transaction Type</label>
                    <select name="transaction_type_id" class="form-select" required>
                        @foreach($transaction_types as $type)
                            <option value="{{ $type->id }}"
                                {{ $transaction_detail->transaction_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name ?? $type->description }}
                            </option>
                        @endforeach
                    </select>
                    @error('transaction_type_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group half">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method_id" class="form-select" required>
                        @foreach($payment_methods as $method)
                            <option value="{{ $method->id }}"
                                {{ $transaction_detail->payment_method_id == $method->id ? 'selected' : '' }}>
                                {{ $method->name ?? $method->method }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_method_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label class="form-label">Status</label>
                    <select name="status_id" class="form-select" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ $transaction_detail->status_id == $status->id ? 'selected' : '' }}>
                                {{ $status->description }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group half">
                    <label class="form-label">Amount (₱)</label>
                    <div class="amount-input-wrapper">
                        <span class="currency-symbol">₱</span>
                        <input type="number"
                               name="amount"
                               class="form-input amount-input"
                               step="0.01"
                               min="0"
                               value="{{ old('amount', $transaction_detail->amount) }}"
                               required>
                    </div>
                    @error('amount')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Transaction Date</label>
                <input type="date" name="transaction_date" class="form-input"
                       value="{{ old('transaction_date', $transaction_detail->transaction_date) }}" required>
                @error('transaction_date')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Transaction Information Box -->
            <div class="info-box">
                <div class="info-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Transaction Information</span>
                </div>
                <div class="info-content">
                    <div class="info-row">
                        <span class="info-label">Created on:</span>
                        <span class="info-value">{{ $transaction_detail->created_at ? $transaction_detail->created_at->format('F d, Y h:i A') : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Last updated:</span>
                        <span class="info-value">{{ $transaction_detail->updated_at ? $transaction_detail->updated_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Transaction ID:</span>
                        <span class="info-value">#{{ $transaction_detail->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Amount:</span>
                        <span class="info-value amount-highlight">₱{{ number_format($transaction_detail->amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                    </svg>
                    Update Transaction
                </button>
                <a href="{{ route('transaction_details.index') }}" class="btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Cancel
                </a>
            </div>
        </form>
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
    .edit-container {
        padding: var(--spacing-lg);
        max-width: 900px;
        margin: 0 auto;
    }

    .edit-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        box-shadow: 0 4px 6px var(--shadow-color);
        overflow: hidden;
    }

    .edit-header {
        padding: 1.75rem 2rem;
        background: var(--accent-color);
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .header-icon {
        background: rgba(255,255,255,0.2);
        padding: 0.75rem;
        border-radius: var(--radius-md);
        color: white;
    }

    .edit-title {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .edit-subtitle {
        font-size: var(--font-size-sm);
        color: rgba(255, 255, 255, 0.8);
        margin: 0.25rem 0 0 0;
    }

    .edit-form {
        padding: var(--spacing-xl);
    }

    .form-row {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    .form-group {
        margin-bottom: var(--spacing-lg);
    }

    .half {
        flex: 1;
        min-width: calc(50% - var(--spacing-md));
    }

    .form-label {
        display: block;
        margin-bottom: var(--spacing-sm);
        font-weight: 500;
        color: var(--text-color);
        font-size: var(--font-size-sm);
    }

    .form-select, .form-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: all var(--transition-fast);
        background: var(--background-color);
        color: var(--text-color);
    }

    .form-select:focus, .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
        background: var(--surface-color);
    }

    .amount-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-symbol {
        position: absolute;
        left: 1rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-light);
        pointer-events: none;
    }

    .amount-input {
        padding-left: 2rem !important;
    }

    .form-error {
        margin-top: var(--spacing-sm);
        font-size: var(--font-size-sm);
        color: var(--danger-color);
    }

    .info-box {
        background-color:  #f3f4f6;
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: var(--spacing-md);
        padding-bottom: var(--spacing-sm);
        border-bottom: 1px solid var(--border-color);
    }

    .info-content {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .info-row {
        display: flex;
        gap: var(--spacing-md);
        font-size: var(--font-size-sm);
    }

    .info-label {
        font-weight: 500;
        color: var(--text-light);
        min-width: 130px;
    }

    .info-value {
        color: var(--text-color);
    }

    .amount-highlight {
        font-weight: 700;
        color: black;
    }

    .form-actions {
        display: flex;
        gap: var(--spacing-md);
        margin-top: var(--spacing-xl);
        padding-top: var(--spacing-md);
        border-top: 1px solid var(--border-color);
    }

    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: 0.7rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: var(--font-size-sm);
        cursor: pointer;
        transition: all var(--transition-fast);
        border: none;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--accent-color);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 56, 168, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: var(--text-light);
    }

    .btn-secondary:hover {
        background: var(--border-color);
    }

    @media (max-width: 768px) {
        .edit-container { padding: var(--spacing-md); }
        .edit-header { padding: 1.25rem 1.5rem; }
        .edit-form { padding: var(--spacing-lg); }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary { justify-content: center; }
        .half { min-width: 100%; }
        .info-row { flex-direction: column; gap: 0.25rem; }
        .info-label { min-width: auto; }
    }
</style>
@endsection
