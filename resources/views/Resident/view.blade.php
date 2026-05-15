@extends('admin.adminpage')

@section('adminContent')
<div class="index-container">
    <!-- Header Section -->
    <div class="index-header">
        <div>
            <h1 class="index-title">Barangay Residents</h1>
            <p class="index-subtitle">Manage resident information and records</p>
        </div>
        <a href="{{ route('residents.create') }}" class="btn-create">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Add Resident
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
                <div class="stat-value">{{ $all_res->count() }}</div>
                <div class="stat-label">Total Residents</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 12v10H4V12M2 8h20M12 2v4M8 2v4M16 2v4"/>
                    <rect x="4" y="12" width="4" height="4"/>
                    <rect x="16" y="12" width="4" height="4"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $all_res->groupBy('street')->count() }}</div>
                <div class="stat-label">Streets</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon accent">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 5h18M3 12h18M3 19h18"/>
                    <rect x="8" y="5" width="8" height="14"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $all_res->whereNotNull('contact_number')->count() }}</div>
                <div class="stat-label">With Contact</div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-box">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>

            <input
                type="text"
                id="searchInput"
                class="search-input"
                placeholder="Search residents by name, address, or contact number..."
            >
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header-actions">
            <div class="table-title">
        </div>
        <div class="table-wrapper">
            <table class="data-table" id="residentsTable">
                <thead>
                    <tr>
                        <th>Resident</th>
                        <th>Contact Number</th>
                        <th>Full Address</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                    <tr class="resident-row">
                        <td class="resident-cell">
                            <div class="resident-info">
                                <div>
                                    <div class="resident-name">
                                        {{ $resident->lastname }}, {{ $resident->firstname }} {{ $resident->middlename ? substr($resident->middlename, 0, 1) . '.' : '' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="contact-cell">
                            @if($resident->contact_number)
                                <span class="contact-badge">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    {{ $resident->contact_number }}
                                </span>
                            @else
                                <span class="no-contact">No contact</span>
                            @endif
                        </td>
                        <td class="full-address-cell">
                            @if($resident->street && $resident->house_number)
                                <span class="address-text">Block {{ $resident->house_number }}, {{ $resident->street }}</span>
                            @elseif($resident->street)
                                <span class="address-text">{{ $resident->street }}</span>
                            @elseif($resident->house_number)
                                <span class="address-text">House #{{ $resident->house_number }}</span>
                            @else
                                <span class="address-text">N/A</span>
                            @endif
                        </td>
                        <td class="actions">
                            <div class="actions-container">
                                <a href="{{ route('residents.edit', $resident->id) }}" class="action-btn edit-btn" title="Edit">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form
                                    action="{{ route('residents.destroy', $resident->id) }}"
                                    method="POST"
                                    class="delete-form"
                                    onsubmit="openDeleteModal(event, this, '{{ $resident->firstname }} {{ $resident->lastname }}')"
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
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <div class="empty-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <p>No residents found</p>
                            <a href="{{ route('residents.create') }}" class="btn-create-sm">Add your first resident</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
                <div class="pagination-wrapper">
                        @if ($residents->hasPages())
                            <div class="custom-pagination">

                                {{-- Previous Button --}}
                                @if ($residents->onFirstPage())
                                    <span class="page-btn disabled">Previous</span>
                                @else
                                    <a href="{{ $residents->previousPageUrl() }}" class="page-btn">
                                        ← Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($residents->getUrlRange(1, $residents->lastPage()) as $page => $url)
                                    @if ($page == $residents->currentPage())
                                        <span class="page-btn active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Button --}}
                                @if ($residents->hasMorePages())
                                    <a href="{{ $residents->nextPageUrl() }}" class="page-btn">
                                        Next →
                                    </a>
                                @else
                                    <span class="page-btn disabled">Next</span>
                                @endif

                            </div>
                        @endif
                    </div>
        </div>
    </div>
</div>

<style>
    :root {
        /* Colors */
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
        --shadow-color: rgba(0, 0, 0, 0.08);

        /* Spacing */
        --spacing-xs: 4px;
        --spacing-sm: 8px;
        --spacing-md: 12px;
        --spacing-lg: 16px;
        --spacing-xl: 24px;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-color);
    }

    /* ================= TABLE WRAPPER ================= */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        overflow: visible;
        max-height: none;
    }

    /* ================= TABLE ================= */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .data-table thead th {
        background: var(--background-color);
        color: var(--text-light);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;

        padding: var(--spacing-md) var(--spacing-lg);
        text-align: left;

        position: sticky;
        top: 0;
    }

    .data-table td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-top: 1px solid var(--border-color);
        vertical-align: middle;
        white-space: nowrap;
    }

    .data-table tbody tr:hover {
        background: var(--background-color);
    }

    /* ================= COLUMN WIDTHS ================= */
    .resident-cell { min-width: 240px; }
    .contact-cell { min-width: 160px; }
    .address-cell,
    .full-address-cell { min-width: 180px; }

    /* ================= ACTIONS ================= */
    .actions {
        display: flex;
        gap: var(--spacing-sm);
        align-items: center;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);

        padding: 6px 10px;
        border-radius: 10px;

        font-size: 12px;
        font-weight: 600;

        text-decoration: none;
        border: none;
        cursor: pointer;

        transition: 200ms ease;
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

    /* ================= SEARCH ================= */
    .search-container {
        margin-bottom: var(--spacing-xl);
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);

        padding: var(--spacing-sm) var(--spacing-md);

        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 14px;

        box-shadow: 0 2px 8px var(--shadow-color);
        transition: 200ms ease;
    }

    .search-box:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(0, 56, 168, 0.1);
    }

    .search-input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 14px;
        background: transparent;
        color: var(--text-color);
    }

    .search-icon {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        color: var(--text-light);
    }

    /* ================= HEADER ================= */
    .index-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: var(--spacing-lg);

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
    }

    /* ================= BUTTON ================= */
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);

        padding: 12px 18px;
        border-radius: 12px;

        font-weight: 600;
        font-size: 0.9rem;

        color: var(--surface-color);
        text-decoration: none;

        background: linear-gradient(
            135deg,
            var(--primary-color),
            var(--secondary-color)
        );

        box-shadow: 0 6px 18px var(--shadow-color);

        transition: 250ms ease;
    }

    .btn-create:hover {
        transform: translateY(-3px);
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
        border-radius: 14px;
        padding: var(--spacing-lg);

        display: flex;
        align-items: center;
        gap: var(--spacing-md);

        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px var(--shadow-color);

        transition: 250ms ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-icon.primary {
        background: rgba(0, 56, 168, 0.12);
        color: var(--primary-color);
    }

    .stat-icon.success {
        background: rgba(22, 163, 74, 0.12);
        color: var(--success-color);
    }

    .stat-icon.accent {
        background: rgba(252, 209, 22, 0.25);
        color: var(--accent-color);
    }

    /* ================= PAGINATION ================= */
    .page-btn {
        padding: 10px 16px;
        border-radius: 10px;

        border: 1px solid var(--border-color);
        background: var(--surface-color);

        color: var(--text-color);
        font-size: 14px;

        transition: 200ms ease;
    }

    .page-btn:hover {
        background: var(--primary-color);
        color: var(--surface-color);
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px) {
        .data-table {
            min-width: 700px;
        }

        .actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .index-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* ================= HIDDEN ================= */
    .hidden-row {
        display: none !important;
    }
</style>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.resident-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.classList.remove('hidden-row');
                visibleCount++;
            } else {
                row.classList.add('hidden-row');
            }
        });

        document.getElementById('visibleCount').textContent = visibleCount;
    });
</script>
@endsection
