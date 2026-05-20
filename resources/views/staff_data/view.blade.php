@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">System Users</h1>
            <p class="index-subtitle">Manage administrator accounts and permissions</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add User
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $users->count() }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M12 3v18"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</div>
                <div class="stat-label">New (30 days)</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $users->where('updated_at', '>=', now()->subDays(7))->count() }}</div>
                <div class="stat-label">Active (7 days)</div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header-actions">
            <div class="table-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>User Accounts</span>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Username</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="user-cell">
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ substr($user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-details">ID: #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="username-cell">
                            <span class="username-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                {{ $user->username }}
                            </span>
                        </td>
                        <td class="email-cell">
                            <span class="email-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                                {{ $user->email }}
                            </span>
                        </td>
                        <td class="role-cell">
                            <span class="role-badge">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="status-cell">
                            <span class="status-badge active">Active</span>
                        </td>
                        <td class="date-cell">
                            <span class="date-text">
                                {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="actions">
                            <div class="actions-container">
                                <a href="{{ route('users.edit', $user->id) }}" class="action-btn edit-btn" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                @if(auth()->id() !== $user->id)
                                <form
                                    action="{{ route('users.destroy', $user->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    onsubmit="openDeleteModal(event, this, '{{ $user->name }}')"
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
                                @else
                                <span class="current-user-badge" title="You cannot delete your own account">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    Current
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div class="empty-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <p>No users found</p>
                            <a href="{{ route('users.create') }}" class="btn-create-sm">Create your first user</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .index-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* HEADER */
    .index-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 32px;
    }

    .index-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1F2937;
        letter-spacing: -0.5px;
    }

    .index-subtitle {
        color: #6B7280;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    /* CREATE BUTTON (FIXED + CLEAN) */
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        background: linear-gradient(135deg, #0038A8, #CE1126);
        color: #ffffff;

        padding: 12px 18px;
        border-radius: 12px;

        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;

        box-shadow: 0 6px 18px rgba(0, 56, 168, 0.25);

        transition: all 0.25s ease;
        border: none;
        cursor: pointer;
    }

    .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 56, 168, 0.3);
    }

    /* STATS */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px;

        display: flex;
        align-items: center;
        gap: 14px;

        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);

        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;

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

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1F2937;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* TABLE */
    .table-container {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid rgba(0,0,0,0.06);

        overflow-x: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #F8FAFC;
    }

    .data-table th {
        padding: 16px 18px;
        text-align: left;

        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;

        color: #6B7280;
        letter-spacing: 0.5px;
    }

    .data-table td {
        padding: 16px 18px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .data-table tbody tr {
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: #F1F5F9;
    }

    /* BADGE */
    .type-badge {
        display: inline-block;
        padding: 4px 10px;

        background: rgba(0, 56, 168, 0.1);
        color: #0038A8;

        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* OFFICIAL */
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

    .official-name {
        font-weight: 600;
        color: #1F2937;
    }

    .official-email {
        font-size: 0.75rem;
        color: #6B7280;
    }

    /* ACTIONS */
    .actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 10px;
        border-radius: 10px;

        font-size: 0.75rem;
        font-weight: 600;

        text-decoration: none;
        border: none;
        cursor: pointer;

        transition: all 0.2s ease;
    }

    .edit-btn {
        background: rgba(0, 56, 168, 0.1);
        color: #0038A8;
    }

    .edit-btn:hover {
        background: rgba(0, 56, 168, 0.2);
        transform: translateY(-1px);
    }

    .delete-btn {
        background: rgba(220, 38, 38, 0.1);
        color: #DC2626;
    }

    .delete-btn:hover {
        background: rgba(220, 38, 38, 0.2);
        transform: translateY(-1px);
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 3rem !important;
        color: #6B7280;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .index-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .actions {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection
