{{-- resources/views/DashboardAdminStaff.blade.php --}}
@extends('index')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Staff Dashboard</h1>
            <p class="page-subtitle">Welcome back, Team! Here's today's community overview.</p>
        </div>
        <div class="date-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <!-- Quick Stats Row - Staff Focused -->
    <div class="quick-stats">
        <div class="quick-stat-card">
            <div class="quick-stat-icon residents">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $total_residents ?? 0 }}</span>
                <span class="quick-stat-label">Total Residents</span>
            </div>
        </div>
        <div class="quick-stat-card">
            <div class="quick-stat-icon certificates">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4v16h16V4H4z M9 9h6M9 13h6M9 17h4"/>
                </svg>
            </div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $total_certificates ?? 0 }}</span>
                <span class="quick-stat-label">Certificates</span>
            </div>
        </div>
        <div class="quick-stat-card">
            <div class="quick-stat-icon pending">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $pending_requests ?? 0 }}</span>
                <span class="quick-stat-label">Pending Requests</span>
            </div>
        </div>
        <div class="quick-stat-card">
            <div class="quick-stat-icon today">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $today_transactions ?? 0 }}</span>
                <span class="quick-stat-label">Today's Transactions</span>
            </div>
        </div>
    </div>

    <!-- Two-Column Layout: Chart (Left) + Stats Cards (Right) -->
    <div class="dashboard-two-columns">
        <!-- LEFT COLUMN: Chart Section -->
        <div class="chart-section">
            <div class="chart-header">
                <div>
                    <h2 class="chart-title">Complaints Trend</h2>
                    <p class="chart-subtitle">Year-over-year complaint statistics</p>
                </div>
                <div class="chart-badge">
                    <span class="badge-dot"></span> Last 7 years
                </div>
            </div>
            <div class="chart-wrapper">
                <canvas id="complaintsChart"></canvas>
            </div>
        </div>

        <!-- RIGHT COLUMN: Staff Action Items -->
        <div class="stats-sidebar">
            <div class="stats-header">
                <h3 class="stats-title">Action Required</h3>
                <p class="stats-subtitle">Items needing your attention</p>
            </div>

            <!-- Priority Action Items -->
            <div class="action-items">
                <div class="action-item urgent">
                    <div class="action-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4m0 4h.01M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/>
                        </svg>
                    </div>
                    <div class="action-content">
                        <span class="action-title">{{ $pending_complaints ?? 0 }} Pending Complaints</span>
                        <span class="action-desc">Requires review and action</span>
                    </div>
                    <a href="{{ route('complaint_details.index') }}" class="action-link">Review →</a>
                </div>

                <div class="action-item warning">
                    <div class="action-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                        </svg>
                    </div>
                    <div class="action-content">
                        <span class="action-title">{{ $pending_certificates ?? 0 }} Pending Certificates</span>
                        <span class="action-desc">Awaiting processing</span>
                    </div>
                    <a href="{{ route('certificate_details.index') }}" class="action-link">Process →</a>
                </div>

                <div class="action-item info">
                    <div class="action-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 10H21M6 19H18M9 19V10M15 19V10M5 4H19L20 10H4L5 4Z"/>
                        </svg>
                    </div>
                    <div class="action-content">
                        <span class="action-title">{{ $unpaid_violations ?? 0 }} Unpaid Violations</span>
                        <span class="action-desc">Payment collection needed</span>
                    </div>
                    <a href="{{ route('violations.index') }}" class="action-link">Collect →</a>
                </div>
            </div>

            <!-- Recent Activity Summary -->
            <div class="recent-activity">
                <div class="activity-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>Recent Activity (Last 7 Days)</span>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <span class="activity-dot complaints"></span>
                        <span class="activity-text">{{ $recent_complaints ?? 0 }} new complaints filed</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot certificates"></span>
                        <span class="activity-text">{{ $recent_certificates ?? 0 }} certificates issued</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot residents"></span>
                        <span class="activity-text">{{ $new_residents ?? 0 }} new residents registered</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot transactions"></span>
                        <span class="activity-text">{{ $recent_transactions ?? 0 }} transactions processed</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot violations"></span>
                        <span class="activity-text">{{ $recent_violations ?? 0 }} violations recorded</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Summary -->
            <div class="stats-summary">
                <div class="summary-item">
                    <span class="summary-label">Open Complaints</span>
                    <span class="summary-value">{{ $open_complaints ?? 0 }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">In-Progress Projects</span>
                    <span class="summary-value">{{ $active_projects ?? 0 }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Active Officials</span>
                    <span class="summary-value">{{ $total_officials ?? 0 }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Completion Rate</span>
                    <span class="summary-value">{{ $completion_rate ?? 0 }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="{{ asset('js/chart.umd.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data = @json($complaintsPerYear ?? []);

        // Sort data by year if needed
        const sortedData = [...data].sort((a, b) => (a.year || 0) - (b.year || 0));

        const labels = sortedData.map(item => item.year);
        const values = sortedData.map(item => item.total);

        const ctx = document.getElementById('complaintsChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Complaints',
                    data: values,
                    backgroundColor: 'rgba(0, 56, 168, 0.8)',
                    borderRadius: 8,
                    barPercentage: 0.65,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            font: { size: 12, family: "'Inter', system-ui" }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return `Complaints: ${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false
                        },
                        title: {
                            display: true,
                            text: 'Number of Complaints',
                            font: { size: 12, weight: '500' },
                            color: '#64748b'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Year',
                            font: { size: 12, weight: '500' },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    /* ================= GLOBAL ================= */

    .dashboard-container{
        max-width: 1500px;
        margin: auto;
        padding: 20px;
    }

    *{
        box-sizing: border-box;
    }

    body{
        background: #f4f6f9;
        font-family: Arial, Helvetica, sans-serif;
        color: #1e293b;
    }

    /* ================= HEADER ================= */

    .page-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .page-title{
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .page-subtitle{
        color: #64748b;
        font-size: 14px;
    }

    .date-badge{
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475569;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    /* ================= QUICK STATS ================= */

    .quick-stats{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .quick-stat-card{
        background: white;
        border-radius: 18px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: 0.25s;
    }

    .quick-stat-card:hover{
        transform: translateY(-4px);
    }

    .quick-stat-icon{
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-stat-icon.residents{
        background: rgba(59,130,246,0.12);
        color: #2563eb;
    }

    .quick-stat-icon.certificates{
        background: rgba(34,197,94,0.12);
        color: #16a34a;
    }

    .quick-stat-icon.pending{
        background: rgba(245,158,11,0.12);
        color: #d97706;
    }

    .quick-stat-icon.today{
        background: rgba(168,85,247,0.12);
        color: #9333ea;
    }

    .quick-stat-value{
        display: block;
        font-size: 28px;
        font-weight: bold;
    }

    .quick-stat-label{
        color: #64748b;
        font-size: 13px;
    }

    /* ================= MAIN GRID ================= */

    .dashboard-two-columns{
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }

    /* ================= CHART ================= */

    .chart-section{
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .chart-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .chart-title{
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .chart-subtitle{
        color: #64748b;
        font-size: 13px;
    }

    .chart-badge{
        background: #f1f5f9;
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-dot{
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #2563eb;
    }

    .chart-wrapper{
        height: 380px;
    }

    /* ================= SIDEBAR ================= */

    .stats-sidebar{
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .stats-header{
        margin-bottom: 20px;
    }

    .stats-title{
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .stats-subtitle{
        font-size: 13px;
        color: #64748b;
    }

    /* ================= ACTION ITEMS ================= */

    .action-items{
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 30px;
    }

    .action-item{
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        transition: 0.25s;
    }

    .action-item:hover{
        transform: translateX(4px);
    }

    .action-item.urgent{
        border-left: 5px solid #dc2626;
    }

    .action-item.warning{
        border-left: 5px solid #f59e0b;
    }

    .action-item.info{
        border-left: 5px solid #2563eb;
    }

    .action-icon{
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
    }

    .action-content{
        flex: 1;
    }

    .action-title{
        display: block;
        font-weight: bold;
        font-size: 14px;
    }

    .action-desc{
        font-size: 12px;
        color: #64748b;
    }

    .action-link{
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        color: #2563eb;
    }

    /* ================= ACTIVITY ================= */

    .recent-activity{
        margin-bottom: 25px;
    }

    .activity-header{
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: bold;
        margin-bottom: 14px;
    }

    .activity-list{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .activity-item{
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .activity-dot{
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .activity-dot.complaints{
        background: #dc2626;
    }

    .activity-dot.certificates{
        background: #16a34a;
    }

    .activity-dot.residents{
        background: #2563eb;
    }

    .activity-dot.transactions{
        background: #9333ea;
    }

    .activity-dot.violations{
        background: #db2777;
    }

    /* ================= SUMMARY ================= */

    .stats-summary{
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 14px;
    }

    .summary-item{
        background: #f8fafc;
        padding: 16px;
        border-radius: 14px;
        text-align: center;
    }

    .summary-label{
        display: block;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .summary-value{
        font-size: 24px;
        font-weight: bold;
    }

    /* ================= RESPONSIVE ================= */

    @media(max-width: 1200px){

        .quick-stats{
            grid-template-columns: repeat(2,1fr);
        }

        .dashboard-two-columns{
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 768px){

        .dashboard-container{
            padding: 15px;
        }

        .quick-stats{
            grid-template-columns: 1fr;
        }

        .stats-summary{
            grid-template-columns: 1fr;
        }

        .page-title{
            font-size: 26px;
        }

        .chart-wrapper{
            height: 280px;
        }
    }
</style>
@endsection
