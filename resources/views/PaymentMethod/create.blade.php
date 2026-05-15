@extends('admin.adminpage')

@section('adminContent')
<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                    <circle cx="7" cy="15" r="1.5" fill="currentColor"/>
                    <circle cx="17" cy="15" r="1.5" fill="currentColor"/>
                </svg>
            </div>
            <div>
                <h1 class="create-title">Create Payment Method</h1>
                <p class="create-subtitle">Add a new payment option for barangay transactions</p>
            </div>
        </div>

        <form action="{{ route('payment_methods.store') }}" method="POST" class="create-form">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Payment Method</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="text"
                       name="method"
                       class="form-input"
                       placeholder="e.g., Cash, GCash, Bank Transfer, Credit Card, Maya"
                       value="{{ old('method') }}"
                       required>
                <p class="input-hint">Common examples: Cash, GCash, PayMaya, Bank Transfer, Credit/Debit Card</p>
                @error('method')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="suggestions-box">
                <div class="suggestions-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Common Payment Methods</span>
                </div>
                <div class="suggestions-list">
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'Cash'">Cash</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'GCash'">GCash</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'PayMaya'">PayMaya</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'Bank Transfer'">Bank Transfer</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'Credit Card'">Credit Card</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'Debit Card'">Debit Card</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'Check'">Check</span>
                    <span class="suggestion-tag" onclick="document.querySelector('input[name=method]').value = 'Online Banking'">Online Banking</span>
                </div>
            </div>

            <div class="info-hint">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>Payment methods will appear as options when processing barangay payments and fees.</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Create Payment Method
                </button>
                <a href="{{ route('payment_methods.index') }}" class="btn-secondary">
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
        max-width: 800px;
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
        background: var(--success-color);
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

    .form-group {
        margin-bottom: var(--spacing-lg);
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

    .form-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: all var(--transition-fast);
        background: var(--background-color);
        color: var(--text-color);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--success-color);
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        background: var(--surface-color);
    }

    .input-hint {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }

    .form-error {
        margin-top: var(--spacing-sm);
        font-size: var(--font-size-sm);
        color: var(--danger-color);
    }

    .suggestions-box {
        background: var(--background-color);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        border: 1px solid var(--border-color);
    }

    .suggestions-header {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-weight: 500;
        color: var(--text-color);
        margin-bottom: var(--spacing-md);
        font-size: var(--font-size-sm);
    }

    .suggestions-list {
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
    }

    .suggestion-tag {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        color: var(--text-color);
        cursor: pointer;
        transition: all var(--transition-fast);
    }

    .suggestion-tag:hover {
        background: var(--success-color);
        color: white;
        border-color: var(--success-color);
        transform: translateY(-1px);
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

    @media (max-width: 640px) {
        .create-container { padding: var(--spacing-md); }
        .create-header { padding: 1.25rem 1.5rem; }
        .create-form { padding: var(--spacing-lg); }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary { justify-content: center; }
        .info-hint { font-size: 0.75rem; }
    }
</style>

<script>
    // Add click handler for suggestion tags
    document.querySelectorAll('.suggestion-tag').forEach(tag => {
        tag.addEventListener('click', function() {
            const input = document.querySelector('input[name=method]');
            input.value = this.textContent;
            input.focus();
        });
    });
</script>
@endsection
