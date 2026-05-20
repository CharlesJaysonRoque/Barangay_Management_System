@extends('admin.adminpage')

@section('adminContent')
<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="create-title">Create Official Title</h1>
                <p class="create-subtitle">Add a new official position for barangay leadership</p>
            </div>
        </div>

        <form action="{{ route('official_titles.store') }}" method="POST" class="create-form">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Official Title</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="text"
                       name="title"
                       class="form-input"
                       placeholder="e.g., Barangay Captain, Kagawad, Secretary, Treasurer"
                       value="{{ old('title') }}"
                       required>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Term Validity (years)</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="number"
                       name="term_validity"
                       class="form-input"
                       placeholder="e.g., 3"
                       step="1"
                       min="1"
                       max="10"
                       value="{{ old('term_validity') }}"
                       required>
                <p class="input-hint">Number of years an official can serve per term</p>
                @error('term_validity')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Max Term Limit</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="number"
                       name="max_term"
                       class="form-input"
                       placeholder="e.g., 3"
                       step="1"
                       min="1"
                       max="20"
                       value="{{ old('max_term') }}"
                       required>
                <p class="input-hint">Maximum number of terms allowed for this position</p>
                @error('max_term')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="info-hint">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>Official titles define the roles and term limits for barangay leadership positions.</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Create Title
                </button>
                <a href="{{ route('official_titles.index') }}" class="btn-secondary">
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
        background: var(--primary-color);
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
        color: rgba(255, 255, 255, 0.8);
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
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.1);
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

    .info-hint {
        background: rgba(0, 56, 168, 0.05);
        border-left: 4px solid var(--primary-color);
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
        background: var(--primary-color);
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

    @media (max-width: 640px) {
        .create-container { padding: var(--spacing-md); }
        .create-header { padding: 1.25rem 1.5rem; }
        .create-form { padding: var(--spacing-lg); }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary { justify-content: center; }
        .info-hint { font-size: 0.75rem; }
    }
</style>
@endsection
