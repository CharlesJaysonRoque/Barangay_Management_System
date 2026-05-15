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
                <h1 class="create-title">Create Fine</h1>
                <p class="create-subtitle">Add a new fine or penalty amount</p>
            </div>
        </div>

        <form action="{{ route('fines.store') }}" method="POST" class="create-form">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Amount</span>
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

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Description</span>
                    <span class="required-badge">Required</span>
                </label>
                <textarea name="description"
                          class="form-textarea"
                          placeholder="Enter detailed description of the fine (e.g., Littering fine, Noise violation penalty, etc.)"
                          rows="4"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="info-hint">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>Fines are monetary penalties issued for barangay ordinance violations.</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Create Fine
                </button>
                <a href="{{ route('fines.index') }}" class="btn-secondary">
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
    }

    /* ================= CONTAINER ================= */
    .create-container {
        padding: var(--spacing-lg);
        max-width: 800px;
        margin: 0 auto;
    }

    .create-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        box-shadow: 0 4px 6px var(--shadow-color);
        overflow: hidden;
    }

    /* ================= HEADER (FIXED) ================= */
    .create-header {
        padding: 1.75rem 2rem;
        background-color: var(--primary-color);
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
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .create-subtitle {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.85);
        margin: 0.25rem 0 0 0;
    }

    /* ================= FORM ================= */
    .create-form {
        padding: var(--spacing-xl);
    }

    /* ================= BUTTONS (FIXED) ================= */
    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: 0.7rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.25s ease;
        border: none;
        text-decoration: none;
    }

    /* PRIMARY BUTTON → ROOT COLORS */
    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        margin-top: var(--radius-xl);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px var(--shadow-lg);
    }

    /* SECONDARY BUTTON */
    .btn-secondary {
        background: var(--background-color);
        color: var(--text-light);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--surface-color);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    /* ================= INPUTS ================= */
    .form-input,
    .form-textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--background-color);
        color: var(--text-color);
        transition: all 0.2s ease;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.15);
        background: var(--surface-color);
    }

    /* ================= HINT BOX ================= */
    .info-hint {
        background: rgba(0, 56, 168, 0.05);
        border-left: 4px solid var(--primary-color);
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        color: var(--text-light);
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 640px) {
        .create-header {
            padding: 1.25rem 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .create-form {
            padding: var(--spacing-lg);
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
