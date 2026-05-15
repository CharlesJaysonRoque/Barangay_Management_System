@extends('admin.adminpage')

@section('adminContent')
<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <path d="M12 18v-4m-2 2h4"/>
                </svg>
            </div>
            <div>
                <h1 class="create-title">Create New Project</h1>
                <p class="create-subtitle">Add a new infrastructure or community project</p>
            </div>
        </div>

        <form action="{{ route('project_details.store') }}" method="POST" class="create-form">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Project Type</span>
                    <span class="required-badge">Required</span>
                </label>
                <select name="project_type_id" class="form-select" required>
                    <option value="">Select project type</option>
                    @foreach($project_types as $type)
                        <option value="{{ $type->id }}" {{ old('project_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->description }}
                        </option>
                    @endforeach
                </select>
                @error('project_type_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Project Description</span>
                    <span class="required-badge">Required</span>
                </label>
                <textarea name="description"
                          class="form-textarea"
                          placeholder="Describe the project details, objectives, and scope..."
                          rows="4"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label class="form-label">
                        <span class="label-text">Start Date</span>
                    </label>
                    <input type="date" name="start_date" class="form-input" value="{{ old('start_date') }}">
                    @error('start_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group half">
                    <label class="form-label">
                        <span class="label-text">Tentative End Date</span>
                    </label>
                    <input type="date" name="tentative_end_date" class="form-input" value="{{ old('tentative_end_date') }}">
                    @error('tentative_end_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Actual End Date</span>
                </label>
                <input type="date" name="actual_end_date" class="form-input" value="{{ old('actual_end_date') }}">
                <p class="input-hint">Leave empty if project is still ongoing</p>
                @error('actual_end_date')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Budget (₱)</span>
                    <span class="required-badge">Required</span>
                </label>
                <div class="amount-input-wrapper">
                    <span class="currency-symbol">₱</span>
                    <input type="number"
                           name="budget"
                           class="form-input amount-input"
                           placeholder="0.00"
                           step="0.01"
                           min="0"
                           value="{{ old('budget') }}"
                           required>
                </div>
                @error('budget')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Project Status</span>
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

            <div class="info-hint">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>Projects help track barangay development initiatives and budget allocation.</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Create Project
                </button>
                <a href="{{ route('project_details.index') }}" class="btn-secondary">
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

    .form-row {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
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

    .form-select, .form-input, .form-textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        transition: all var(--transition-fast);
        background: var(--background-color);
        color: var(--text-color);
    }

    .form-select {
        color: var(--text-color);
        background-color: var(--background-color);
    }

    .form-select option {
        color: #000;              /* force visible text */
        background-color: #fff;   /* white background */
    }

    .form-textarea {
        resize: vertical;
        font-family: inherit;
    }

    .form-select:focus, .form-input:focus, .form-textarea:focus {
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
