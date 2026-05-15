@extends('admin.adminpage')

@section('adminContent')
<div class="edit-container">
    <div class="edit-card">
        <div class="edit-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    <path d="M12 8v4m0 4h.01"/>
                </svg>
            </div>
            <div>
                <h1 class="edit-title">Edit Complaint Type</h1>
                <p class="edit-subtitle">Update complaint category information</p>
            </div>
        </div>

        <form action="{{ route('complaint_types.update', $complaint_type->id) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Description</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="text"
                       name="description"
                       class="form-input"
                       placeholder="Enter complaint type"
                       value="{{ old('description', $complaint_type->description) }}"
                       required>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            @php
                $complaintCount = \App\Models\ComplaintDetail::where('complaint_type_id', $complaint_type->id)->count();
            @endphp

            @if($complaintCount > 0)
                <div class="warning-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <strong>Warning:</strong> This complaint type is used in {{ $complaintCount }} complaint(s).<br>
                        Updating the description will affect all associated complaints.
                    </div>
                </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                    </svg>
                    Update Changes
                </button>
                <a href="{{ route('complaint_types.index') }}" class="btn-secondary">
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
        max-width: 800px;
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
        color: rgba(255,255,255,0.8);
        margin: 0.25rem 0 0 0;
    }

    .edit-form {
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
        border-color: var(--warning-color);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        background: var(--surface-color);
    }

    .form-error {
        margin-top: var(--spacing-sm);
        font-size: var(--font-size-sm);
        color: var(--danger-color);
    }

    .warning-box {
        background: rgba(245, 158, 11, 0.1);
        border-left: 4px solid var(--warning-color);
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        margin-bottom: var(--spacing-lg);
        display: flex;
        align-items: flex-start;
        gap: var(--spacing-sm);
        font-size: var(--font-size-sm);
        color: var(--warning-color);
    }

    .warning-box svg {
        flex-shrink: 0;
        margin-top: 2px;
    }

    .warning-box strong {
        font-weight: 700;
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
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: var(--text-light);
    }

    .btn-secondary:hover {
        background: var(--border-color);
    }

    @media (max-width: 640px) {
        .edit-container { padding: var(--spacing-md); }
        .edit-header { padding: 1.25rem 1.5rem; }
        .edit-form { padding: var(--spacing-lg); }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary { justify-content: center; }
    }
</style>
@endsection
