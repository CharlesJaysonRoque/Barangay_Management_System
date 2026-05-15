@extends('admin.adminpage')

@section('adminContent')
<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                    <circle cx="12" cy="12" r="2"/>
                </svg>
            </div>
            <div>
                <h1 class="create-title">Record Transaction</h1>
                <p class="create-subtitle">Log a new financial transaction</p>
            </div>
        </div>

        <form action="{{ route('transaction_details.store') }}" method="POST" class="create-form">
            @csrf

            <div class="form-row">
                <div class="form-group half">
                    <label class="form-label">
                        <span class="label-text">Transaction Type</span>
                        <span class="required-badge">Required</span>
                    </label>
                    <select name="transaction_type_id" class="form-select" required>
                        <option value="">Select transaction type</option>
                        @foreach($transaction_types as $type)
                            <option value="{{ $type->id }}" {{ old('transaction_type_id') == $type->id ? 'selected' : '' }}>
                                {{$type->description }}
                            </option>
                        @endforeach
                    </select>
                    @error('transaction_type_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group half">
                    <label class="form-label">
                        <span class="label-text">Payment Method</span>
                        <span class="required-badge">Required</span>
                    </label>
                    <select name="payment_method_id" class="form-select" required>
                        <option value="">Select payment method</option>
                        @foreach($payment_methods as $method)
                            <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
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
                    <label class="form-label">
                        <span class="label-text">Status</span>
                        <span class="required-badge">Required</span>
                    </label>
                    <select name="status_id" class="form-select" required>
                        <option value="">Select status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->description }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group half">
                    <label class="form-label">
                        <span class="label-text">Amount (₱)</span>
                        <span class="required-badge">Required</span>
                    </label>
                    <div class="amount-input-wrapper">
                        <span class="currency-symbol">₱</span>
                        <input type="number"
                               name="amount"
                               class="form-input amount-input"
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               value="{{ old('amount') }}"
                               required>
                    </div>
                    @error('amount')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Transaction Date</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="date" name="transaction_date" class="form-input" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                @error('transaction_date')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="info-hint">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>Track all barangay income including permits, clearances, and other fees.</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Record Transaction
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
    .create-container {
        padding: var(--spacing-lg);
        max-width: 900px;
        margin: 0 auto;
    }

    .create-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        box-shadow: 0 4px 6px var(--shadow-color);
        overflow: hidden;
    }

    .create-header {
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, var(--success-color) 0%, #13803b 100%);
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

    .create-title {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .create-subtitle {
        font-size: var(--font-size-sm);
        color: rgba(255,255,255,0.8);
        margin: 0.25rem 0 0 0;
    }

    .create-form {
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-sm);
        font-weight: 500;
        color: var(--text-color);
    }

    .label-text {
        font-size: var(--font-size-sm);
    }

    .required-badge {
        font-size: 0.7rem;
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
        padding: 0.2rem 0.5rem;
        border-radius: var(--radius-full);
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
        border-color: var(--success-color);
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
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

    .info-hint {
        background: rgba(0, 56, 168, 0.05);
        border-left: 4px solid var(--success-color);
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        margin-bottom: var(--spacing-lg);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-size: var(--font-size-sm);
        color: var(--text-light);
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
        background: var(--success-color);
        color: white;
    }

    .btn-primary:hover {
        background: #13803b;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: var(--text-light);
    }

    .btn-secondary:hover {
        background: var(--border-color);
    }

    @media (max-width: 768px) {
        .create-container { padding: var(--spacing-md); }
        .create-header { padding: 1.25rem 1.5rem; }
        .create-form { padding: var(--spacing-lg); }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary { justify-content: center; }
        .half { min-width: 100%; }
        .info-hint { font-size: 0.75rem; }
    }
</style>
@endsection
