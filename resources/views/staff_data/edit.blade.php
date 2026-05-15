@extends('admin.adminpage')

@section('adminContent')
<div class="edit-container">
    <div class="edit-card">
        <div class="edit-header">
            <div class="header-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
            </div>
            <div>
                <h1 class="edit-title">Edit User Account</h1>
                <p class="edit-subtitle">Update user information and password</p>
            </div>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Full Name</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Username</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="text" name="username" class="form-input" value="{{ old('username', $user->username) }}" required>
                @error('username')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">Email Address</span>
                    <span class="required-badge">Required</span>
                </label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-text">New Password</span>
                    <span class="optional-badge">Optional</span>
                </label>
                <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current password">
                <p class="input-hint">Leave empty to keep the existing password. Minimum 8 characters for new password.</p>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- User Information Box -->
            <div class="info-box">
                <div class="info-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Account Information</span>
                </div>
                <div class="info-content">
                    <div class="info-row">
                        <span class="info-label">Created on:</span>
                        <span class="info-value">{{ $user->created_at ? $user->created_at->format('F d, Y h:i A') : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Last updated:</span>
                        <span class="info-value">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Account ID:</span>
                        <span class="info-value">#{{ $user->id }}</span>
                    </div>
                    @if(auth()->id() === $user->id)
                    <div class="info-row">
                        <span class="info-label"></span>
                        <span class="info-value current-badge">This is your current account</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/>
                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/>
                    </svg>
                    Update Account
                </button>
                <a href="{{ route('users.index') }}" class="btn-secondary">
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
    /* ================= COLORS ================= */

    --primary-color: #0038A8;
    --secondary-color: #CE1126;
    --accent-color: #FCD116;

    /* Hover Colors */
    --primary-hover: #002d87;
    --secondary-hover: #a80e20;
    --accent-hover: #e0b800;

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

    /* ================= SPACING ================= */

    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;

    /* ================= BORDER RADIUS ================= */

    --radius-sm: 0.25rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
    --radius-2xl: 1.5rem;
    --radius-3xl: 2rem;
    --radius-full: 999px;

    /* ================= FONT SIZES ================= */

    --font-size-xs: 0.7rem;
    --font-size-sm: 0.85rem;
    --font-size-md: 1rem;
    --font-size-lg: 1.25rem;
    --font-size-xl: 1.5rem;
    --font-size-2xl: 2rem;

    /* ================= TRANSITIONS ================= */

    --transition-fast: 150ms ease;
    --transition-base: 250ms ease;
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

/* ================= HEADER ================= */

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
    color: var(--surface-color);
}

.edit-title {
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: white;
    margin: 0;
}

.edit-subtitle {
    font-size: var(--font-size-md);
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500%;
    margin: 0.25rem 0 0 0;
}

/* ================= FORM ================= */

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

/* ================= BADGES ================= */

.required-badge,
.optional-badge,
.current-badge {
    padding: 0.2rem 0.6rem;
    border-radius: var(--radius-full);
    font-size: var(--font-size-xs);
    font-weight: 500;
}

.required-badge {
    background: rgba(220, 38, 38, 0.1);
    color: var(--danger-color);
}

.optional-badge {
    background: rgba(107, 114, 128, 0.1);
    color: var(--text-light);
}

.current-badge {
    background: rgba(252, 209, 22, 0.2);
    color: #9a7200;
}

/* ================= INPUTS ================= */

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

    border-color: var(--accent-color);

    box-shadow: 0 0 0 3px rgba(252, 209, 22, 0.2);

    background: var(--surface-color);
}

.input-hint {
    font-size: var(--font-size-xs);
    color: var(--text-light);
    margin-top: 0.25rem;
}

.form-error {
    margin-top: var(--spacing-sm);
    font-size: var(--font-size-sm);
    color: var(--danger-color);
}

/* ================= INFO BOX ================= */

.info-box {
    background: #f3f4f6;
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
    min-width: 120px;
}

.info-value {
    color: var(--text-color);
}

/* ================= ACTIONS ================= */

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
    font-size: var(--font-size-sm);

    cursor: pointer;

    transition: all var(--transition-fast);

    border: none;
    text-decoration: none;
}

/* ================= PRIMARY BUTTON ================= */

.btn-primary {
    background: var(--accent-color);
    color: white;
}

.btn-primary:hover {
    background: var(--accent-hover);

    transform: translateY(-1px);

    box-shadow: 0 4px 12px rgba(252, 209, 22, 0.35);
}

/* ================= SECONDARY BUTTON ================= */

.btn-secondary {
    background: #f3f4f6;
    color: var(--text-light);
}

.btn-secondary:hover {
    background: var(--border-color);
}

/* ================= RESPONSIVE ================= */

@media (max-width: 640px) {

    .edit-container {
        padding: var(--spacing-md);
    }

    .edit-header {
        padding: 1.25rem 1.5rem;
    }

    .edit-form {
        padding: var(--spacing-lg);
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-primary,
    .btn-secondary {
        justify-content: center;
    }

    .info-row {
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        min-width: auto;
    }
}
</style>
@endsection
