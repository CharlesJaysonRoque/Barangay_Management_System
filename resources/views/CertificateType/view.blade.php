@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Certificate Types</h1>
            <p class="index-subtitle">Manage certificate types for barangay documents</p>
        </div>
        <a href="{{ route('certificate_types.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Certificate Type
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $certificate_types->count() }}</div>
                <div class="stat-label">Total Types</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\CertificateDetail::count() }}</div>
                <div class="stat-label">Active Assignments</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center">Description</th>
                    <th class="text-center">Assigned Official</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificate_types as $certificate_type)
                @php
                    $assignments = \App\Models\CertificateDetail::where('certificate_type_id', $certificate_type->id)->get();
                @endphp
                <tr>
                    <td class="text-center">
                        <span class="type-badge">
                            {{ $certificate_type->description }}
                        </span>
                    </td>
                    <td class="text-center">
                        @php
                            $assignments = \App\Models\CertificateDetail::where('certificate_type_id', $certificate_type->id)->get();
                        @endphp

                        @if($assignments->count())

                            @foreach($assignments as $assignment)

                                @if($assignment->official && $assignment->official->resident)
                                    <div class="official-info">
                                        <span class="official-name-small">
                                            {{ $assignment->official->resident->lastname }},
                                            {{ $assignment->official->resident->firstname }}
                                        </span>
                                    </div>
                                @endif

                            @endforeach

                        @else
                            <div class="official-info">
                                <span class="official-name-small delete-btn">
                                    Not Assigned
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="actions-container">
                            <a href="{{ route('certificate_types.edit', $certificate_type->id) }}" class="action-btn edit-btn" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                                Edit
                            </a>
                            @if($assignments->count() > 0)
                                <div class="warning-tooltip">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span class="tooltip-text">Cannot delete - has assigned certificate(s)</span>
                                </div>
                            @else
                            <form
                                action="{{ route('certificate_types.destroy', $certificate_type->id) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="openDeleteModal(event, this, '{{ $certificate_type->description }}')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-btn delete-btn" title="Delete">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="empty-state">
                        <div class="empty-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                            </svg>
                        </div>
                        <p>No certificate types found</p>
                        <a href="{{ route('certificate_types.create') }}" class="btn-create-sm">Create your first certificate type</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $certificate_types->links() }}
        </div>
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

        --shadow-sm: 0 2px 6px rgba(0,0,0,0.08);
        --shadow-md: 0 6px 16px rgba(0,0,0,0.10);
        --shadow-lg: 0 12px 28px rgba(0,0,0,0.15);

        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;

        --radius-sm: 0.25rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;

        --transition-fast: 150ms ease;
        --transition-base: 250ms ease;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-color);
    }

    /* ================= CONTAINER ================= */

    .index-container {
        padding: var(--spacing-xl);
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= HEADER ================= */

    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-xl);
    }

    .index-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-color);
    }

    .index-subtitle {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-top: var(--spacing-xs);
    }

    /* ================= BUTTON ================= */

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);

        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;

        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--radius-lg);

        font-weight: 600;
        text-decoration: none;

        box-shadow: var(--shadow-md);
        transition: var(--transition-base);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* ================= STATS ================= */

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-xl);
    }

    .stat-card {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--spacing-md);

        display: flex;
        align-items: center;
        gap: var(--spacing-md);

        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);

        transition: var(--transition-base);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.primary {
        background: rgba(0, 56, 168, 0.12);
        color: #0038A8;
    }

    .stat-icon.success {
        background: rgba(22, 163, 74, 0.12);
        color: #16A34A;
    }

    .stat-icon.accent {
        background: rgba(252, 209, 22, 0.25);
        color: #FCD116;
    }

    /* ================= TABLE FIX (IMPORTANT PART) ================= */

    .table-container {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);

        overflow-x: auto;
        overflow-y: hidden; /* 🔥 IMPORTANT FIX */
        box-shadow: var(--shadow-sm);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* 🔥 KEY FIX (prevents overflow behavior) */
    }

    .data-table th,
    .data-table td {
        padding: var(--spacing-md);
        vertical-align: middle;
        word-wrap: break-word;
        white-space: normal;
        text-align: center;
    }

    .data-table thead {
        background: var(--background-color);
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
    }

    /* ================= CENTER ALIGN FIX ================= */

    .text-center {
        text-align: center;
    }

    /* ================= ACTIONS FIX ================= */

    .actions-container {
        display: flex;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);

        padding: 6px 10px;
        border-radius: var(--radius-md);

        font-size: 0.75rem;
        font-weight: 600;

        text-decoration: none;
        border: none;
        cursor: pointer;

        transition: var(--transition-fast);
    }

    .edit-btn {
        background: rgba(0, 56, 168, 0.1);
        color: var(--primary-color);
    }

    .edit-btn:hover {
        background: rgba(0, 56, 168, 0.2);
    }

    .delete-btn {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
    }

    .delete-btn:hover {
        background: rgba(220, 38, 38, 0.2);
    }

    /* ================= BADGE ================= */

    .type-badge {
        display: inline-block;
        padding: var(--spacing-xs) var(--spacing-sm);
        background: rgba(0, 56, 168, 0.1);
        color: var(--primary-color);
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .official-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .official-avatar {
        width: 38px;
        height: 38px;

        background: linear-gradient(135deg, #0038A8, #CE1126);
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #fff;
        font-weight: 700;
        font-size: 0.8rem;
    }

    /* ================= EMPTY ================= */

    .empty-state {
        text-align: center;
        padding: var(--spacing-xl);
        color: var(--text-light);
    }
</style>
@endsection
