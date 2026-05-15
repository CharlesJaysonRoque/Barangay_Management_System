{{-- resources/views/Dashboard.blade.php --}}
@extends('index')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back! Here's what's happening with your community today.</p>
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

    <!-- Quick Stats Row -->
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
            <div class="quick-stat-trend up">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="18 15 12 9 6 15"/>
                </svg>
                <span>+12%</span>
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
                <span class="quick-stat-label">Certificates Issued</span>
            </div>
            <div class="quick-stat-trend up">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="18 15 12 9 6 15"/>
                </svg>
                <span>+8%</span>
            </div>
        </div>
        <div class="quick-stat-card">
            <div class="quick-stat-icon complaints">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    <line x1="9" y1="10" x2="15" y2="10"/>
                </svg>
            </div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">{{ $total_complaints ?? 0 }}</span>
                <span class="quick-stat-label">Total Complaints</span>
            </div>
            <div class="quick-stat-trend down">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
                <span>-5%</span>
            </div>
        </div>
        <div class="quick-stat-card">
            <div class="quick-stat-icon revenue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div class="quick-stat-info">
                <span class="quick-stat-value">₱{{ number_format($total_revenue ?? 0, 2) }}</span>
                <span class="quick-stat-label">Total Revenue</span>
            </div>
            <div class="quick-stat-trend up">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="18 15 12 9 6 15"/>
                </svg>
                <span>+18%</span>
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

        <!-- RIGHT COLUMN: Detailed Stats -->
        <div class="stats-sidebar">
            <div class="stats-header">
                <h3 class="stats-title">Community Overview</h3>
                <p class="stats-subtitle">Key metrics at a glance</p>
            </div>
            <div class="stats-grid">
                <div class="stat-card stat-projects">
                    <div class="stat-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $total_projects ?? 0 }}</span>
                        <span class="stat-label">Total Projects</span>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 65%"></div>
                    </div>
                </div>

                <div class="stat-card stat-transactions">
                    <div class="stat-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $total_transactions ?? 0 }}</span>
                        <span class="stat-label">Transactions</span>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 78%"></div>
                    </div>
                </div>

                <div class="stat-card stat-violations">
                    <div class="stat-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4m0 4h.01M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $total_violations ?? 0 }}</span>
                        <span class="stat-label">Violations</span>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 42%"></div>
                    </div>
                </div>

                <div class="stat-card stat-officials">
                    <div class="stat-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $total_officials ?? 0 }}</span>
                        <span class="stat-label">Active Officials</span>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Summary -->
            <div class="recent-activity">
                <div class="activity-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>Recent Activity</span>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <span class="activity-dot complaints"></span>
                        <span class="activity-text">{{ $recent_complaints ?? 0 }} new complaints this week</span>
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
                        <span class="activity-text">₱{{ number_format($recent_revenue ?? 0, 2) }} collected this month</span>
                    </div>
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

    *{
        box-sizing: border-box;
    }

    body{
        background: #f1f5f9;
        font-family: Arial, Helvetica, sans-serif;
        color: #1e293b;
    }

    .dashboard-container{
        max-width: 1600px;
        margin: auto;
        padding: 20px;
    }

    /* ================= HEADER ================= */

    .page-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .page-title{
        font-size: 34px;
        font-weight: bold;
        margin-bottom: 6px;
    }

    .page-subtitle{
        color: #64748b;
        font-size: 14px;
    }

    .date-badge{
        background: white;
        padding: 10px 18px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        color: #475569;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* ================= QUICK STATS ================= */

    .quick-stats{
        display: grid;
        grid-template-columns: repeat(4,1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .quick-stat-card{
        background: white;
        border-radius: 20px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        transition: 0.25s;
    }

    .quick-stat-card:hover{
        transform: translateY(-4px);
    }

    .quick-stat-icon{
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .quick-stat-icon.residents{
        background: rgba(37,99,235,0.12);
        color: #2563eb;
    }

    .quick-stat-icon.certificates{
        background: rgba(34,197,94,0.12);
        color: #16a34a;
    }

    .quick-stat-icon.complaints{
        background: rgba(239,68,68,0.12);
        color: #dc2626;
    }

    .quick-stat-icon.revenue{
        background: rgba(168,85,247,0.12);
        color: #9333ea;
    }

    .quick-stat-info{
        flex: 1;
    }

    .quick-stat-value{
        display: block;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .quick-stat-label{
        font-size: 13px;
        color: #64748b;
    }

    .quick-stat-trend{
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: bold;
    }

    .quick-stat-trend.up{
        background: rgba(34,197,94,0.12);
        color: #16a34a;
    }

    .quick-stat-trend.down{
        background: rgba(239,68,68,0.12);
        color: #dc2626;
    }

    /* ================= MAIN GRID ================= */

    .dashboard-two-columns{
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    /* ================= CHART SECTION ================= */

    .chart-section{
        background: white;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }

    .chart-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .chart-title{
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .chart-subtitle{
        color: #64748b;
        font-size: 13px;
    }

    .chart-badge{
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
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
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }

    .stats-header{
        margin-bottom: 22px;
    }

    .stats-title{
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .stats-subtitle{
        color: #64748b;
        font-size: 13px;
    }

    /* ================= STAT CARDS ================= */

    .stats-grid{
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card{
        background: #f8fafc;
        border-radius: 18px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: 0.25s;
        border: 1px solid transparent;
        flex-wrap: wrap;
    }

    .stat-card:hover{
        border-color: #2563eb;
        transform: translateX(4px);
    }

    .stat-icon{
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-projects .stat-icon{
        background: rgba(245,158,11,0.12);
        color: #d97706;
    }

    .stat-transactions .stat-icon{
        background: rgba(99,102,241,0.12);
        color: #4f46e5;
    }

    .stat-violations .stat-icon{
        background: rgba(236,72,153,0.12);
        color: #db2777;
    }

    .stat-officials .stat-icon{
        background: rgba(37,99,235,0.12);
        color: #2563eb;
    }

    .stat-content{
        flex: 1;
    }

    .stat-value{
        display: block;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 3px;
    }

    .stat-label{
        font-size: 12px;
        color: #64748b;
    }

    .stat-progress{
        width: 100%;
        height: 6px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
        margin-top: 10px;
    }

    .progress-bar{
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(to right, #2563eb, #9333ea);
    }

    /* ================= RECENT ACTIVITY ================= */

    .recent-activity{
        border-top: 1px solid #e2e8f0;
        padding-top: 22px;
    }

    .activity-header{
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: bold;
        margin-bottom: 16px;
    }

    .activity-list{
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .activity-item{
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #475569;
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

        .page-title{
            font-size: 28px;
        }

        .quick-stats{
            grid-template-columns: 1fr;
        }

        .chart-wrapper{
            height: 280px;
        }

        .quick-stat-card{
            flex-wrap: wrap;
        }
    }
</style>
@endsection
