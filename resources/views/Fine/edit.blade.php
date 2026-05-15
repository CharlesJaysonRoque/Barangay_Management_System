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
                <h1 class="edit-title">Edit Fine</h1>
                <p class="edit-subtitle">Update fine amount and description</p>
            </div>
        </div>

        <form action="{{ route('fines.update', $fine->id) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

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
                           value="{{ old('amount', $fine->amount) }}"
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
                          placeholder="Enter detailed description of the fine"
                          rows="4"
                          required>{{ old('description', $fine->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Case Information Display -->
            <div class="info-box">
                <div class="info-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Fine Information</span>
                </div>
                <div class="info-content">
                    <div class="info-row">
                        <span class="info-label">Created on:</span>
                        <span class="info-value">{{ $fine->created_at ? $fine->created_at->format('F d, Y h:i A') : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Last updated:</span>
                        <span class="info-value">{{ $fine->updated_at ? $fine->updated_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fine ID:</span>
                        <span class="info-value">#{{ $fine->id }}</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                    </svg>
                    Update Fine
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
        --primary-color: #0038A8;
        --secondary-color: #CE1126;
        --accent-color: #FCD116;

        --background-color: #F8FAFC;
        --surface-color: #FFFFFF;
        --text-color: #1F2937;
        --text-light: #6B7280;

        --success-color: #16A34A;
        --warning-color: #F59E0B;
        --danger-color: #DC2626;

        --border-color: #D1D5DB;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --shadow-lg: rgba(0, 0, 0, 0.15);

        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;

        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    /* ================= CONTAINER ================= */
    .edit-container {
        padding: var(--spacing-lg);
        max-width: 800px;
        margin: 0 auto;
    }

    .edit-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        box-shadow: 0 4px 6px var(--shadow-color);
        overflow: hidden;
    }

    /* ================= HEADER FIX ================= */
    .edit-header {
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--warning-color) 100%);
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
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .edit-subtitle {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.85);
        margin: 0.25rem 0 0 0;
    }

    /* ================= FORM ================= */
    .edit-form {
        padding: var(--spacing-xl);
    }

    .form-group {
        margin-bottom: var(--spacing-lg);
    }

    /* ================= INPUTS ================= */
    .form-input,
    .form-textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: all 0.2s ease;
        background: var(--background-color);
        color: var(--text-color);
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
        background: var(--surface-color);
    }

    .form-textarea {
        resize: vertical;
    }

    /* ================= ERROR ================= */
    .form-error {
        margin-top: var(--spacing-sm);
        font-size: 0.8rem;
        color: var(--danger-color);
    }

    /* ================= INFO BOX ================= */
    .info-box {
        background: var(--background-color);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        border: 1px solid var(--border-color);
    }

    /* ================= BUTTONS FIX ================= */
    .form-actions {
        display: flex;
        gap: var(--spacing-md);
        margin-top: var(--spacing-xl);
        padding-top: var(--spacing-md);
        border-top: 1px solid var(--border-color);
    }

    .btn-primary,
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: 0.7rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
    }

    /* PRIMARY BUTTON FIXED */
    .btn-primary {
        background-color: var(--accent-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--accent-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px var(--shadow-lg);
    }

    /* SECONDARY BUTTON */
    .btn-secondary {
        background: #f3f4f6;
        color: var(--text-light);
    }

    .btn-secondary:hover {
        background: var(--border-color);
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 640px) {
        .edit-container { padding: var(--spacing-md); }

        .edit-header {
            padding: 1.25rem 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .edit-form { padding: var(--spacing-lg); }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            justify-content: center;
        }
    }
</style>
@endsection
