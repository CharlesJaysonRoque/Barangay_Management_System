@extends('admin.adminpage')

@section('adminContent')
<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="12" y1="18" x2="12" y2="12"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <h1 class="create-title">Create Certificate Type</h1>
                <p class="create-subtitle">Add a new certificate type for barangay documents</p>
            </div>
        </div>

        <form action="{{ route('certificate_types.store') }}" method="POST" class="create-form">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Description</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="text"
                       name="description"
                       class="form-input"
                       placeholder="Enter certificate type (e.g., Barangay Clearance, Certificate of Residency)"
                       value="{{ old('description') }}"
                       required>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Create Certificate Type
                </button>
                <a href="{{ route('certificate_types.index') }}" class="btn-secondary">
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

        /* Borders & Shadows */
        --border-color: #D1D5DB;
        --shadow-color: rgba(0, 0, 0, 0.1);

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

    /* ================= CARD ================= */

    .create-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        box-shadow: 0 4px 6px var(--shadow-color);
        overflow: hidden;
    }

    /* ================= HEADER ================= */

    .create-header {
        padding: var(--spacing-lg) var(--spacing-xl);
        background-color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    /* ICON */

    .header-icon {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.75rem;
        border-radius: var(--radius-md);
        color: #fff;
    }

    /* TEXT (FIXED VISIBILITY) */

    .create-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }

    .create-subtitle {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        margin: 4px 0 0 0;
    }

    /* ================= FORM ================= */

    .create-form {
        padding: var(--spacing-xl);
    }

    /* GROUP */

    .form-group {
        margin-bottom: var(--spacing-lg);
    }

    /* LABEL */

    .form-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-sm);
        font-weight: 500;
        color: var(--text-color);
    }

    .label-text {
        font-size: 0.9rem;
    }

    /* REQUIRED BADGE (FIXED radius-full issue) */

    .required-badge {
        font-size: 0.7rem;
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
    }

    /* INPUT */

    .form-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: 0.2s ease;
        background: var(--background-color);
        color: var(--text-color);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
        background: var(--surface-color);
    }

    /* ERROR */

    .form-error {
        margin-top: var(--spacing-sm);
        font-size: 0.8rem;
        color: var(--danger-color);
    }

    /* ================= BUTTONS ================= */

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
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.2s ease;
        border: none;
        text-decoration: none;
    }

    /* PRIMARY BUTTON */

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: #002f8a;
        transform: translateY(-1px);
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
        .create-container {
            padding: var(--spacing-md);
        }

        .create-header {
            padding: var(--spacing-md);
        }

        .create-form {
            padding: var(--spacing-lg);
        }

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
