<?php
/**
 * WAMDEVIN Admin Dashboard - Homepage
 * 
 * Main dashboard with widgets, statistics, and overview
 * 
 * @version 2.0.0
 * @since February 2026
 */

// ==============================================
// PAGE CONFIGURATION
// ==============================================

$pageTitle = "Dashboard - WAMDEVIN Admin";
$pageDescription = "Strategic command center for WAMDEVIN leadership, impact, and institutional excellence";

if (isset($_GET['debug']) && $_GET['debug'] === '1') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// Features configuration
$useCalendar = true;
$useCharts = true;
$useCounter = true;
$includeLegacyCSS = true;  // For backward compatibility
$includeLegacyJS = true;   // For chart.js and fullcalendar

// Current page for navigation
$currentPage = 'dashboard';

// Include modern header component
include('includes/admin-header.php');

// Include sidebar component
include('includes/admin-sidebar.php');

$dashboardData = getDashboardData();
?>

<!-- Main Container Start -->
<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        
        <!-- Breadcrumb -->
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Leadership & Impact Overview</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <li>Dashboard</li>
            </ul>
        </div>

        <?php if (!empty($dashboardData['dbError'])): ?>
            <div class="alert alert-warning wam-alert" role="alert">
                <strong>Data connection unavailable.</strong> The dashboard is running in safe mode. Check database credentials or start MySQL to load live metrics.
            </div>
        <?php endif; ?>

        <!-- WAMDEVIN Excellence Brief -->
        <div class="row m-b30">
            <div class="col-12">
                <div class="widget-box">
                    <div class="wc-title">
                        <h4>WAMDEVIN Excellence Brief</h4>
                    </div>
                    <div class="widget-inner">
                        <p class="wam-brief-lead">
                            Advancing public sector leadership across West Africa through evidence-led programming, collaborative research, and regional partnerships that turn strategy into measurable results.
                        </p>
                        <div class="row">
                            <div class="col-md-4 m-b20">
                                <div class="wam-brief-card">
                                    <div class="wam-brief-icon">
                                        <i class="fa fa-chart-line" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="wam-brief-title">Impact at Scale</h5>
                                    <p class="wam-brief-text">Regional programmes and advisory engagements improving governance outcomes and institutional performance.</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-b20">
                                <div class="wam-brief-card wam-brief-card--accent">
                                    <div class="wam-brief-icon wam-brief-icon--accent">
                                        <i class="fa fa-compass" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="wam-brief-title">Methodology that Delivers</h5>
                                    <p class="wam-brief-text">Co-designed programmes, applied research, and continuous learning cycles that sustain performance.</p>
                                </div>
                            </div>
                            <div class="col-md-4 m-b20">
                                <div class="wam-brief-card wam-brief-card--success">
                                    <div class="wam-brief-icon wam-brief-icon--success">
                                        <i class="fa fa-rocket" aria-hidden="true"></i>
                                    </div>
                                    <h5 class="wam-brief-title">Opportunity Pipeline</h5>
                                    <p class="wam-brief-text">New partnerships, flagship initiatives, and leadership exchanges across member institutions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row">
            
            <!-- Total Member Institutions Card -->
            <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
                <div class="widget-card widget-bg1">
                    <div class="wc-item">
                        <h4 class="wc-title">Total Member Institutions</h4>
                        <span class="wc-des">Regional network coverage</span>
                        <span class="wc-stats counter"><?php echo isset($dashboardData['metrics']['memberInstitutions']) && $dashboardData['metrics']['memberInstitutions'] !== null ? $dashboardData['metrics']['memberInstitutions'] : '—'; ?></span>
                        <div class="progress wc-progress">
                               <div class="progress-bar wam-progress-bar" 
                                 role="progressbar" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"
                                   aria-label="Data pending"></div>
                        </div>
                        <span class="wc-progress-bx">
                            <span class="wc-change">Members</span>
                            <span class="wc-number ml-auto">Verified</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Events Card -->
            <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
                <div class="widget-card widget-bg2">
                    <div class="wc-item">
                        <h4 class="wc-title">Upcoming Events</h4>
                        <span class="wc-des">Next 90 days pipeline</span>
                        <span class="wc-stats counter"><?php echo isset($dashboardData['metrics']['upcomingEvents']) && $dashboardData['metrics']['upcomingEvents'] !== null ? $dashboardData['metrics']['upcomingEvents'] : '—'; ?></span>
                        <div class="progress wc-progress">
                               <div class="progress-bar wam-progress-bar" 
                                 role="progressbar" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"
                                   aria-label="Data pending"></div>
                        </div>
                        <span class="wc-progress-bx">
                            <span class="wc-change">Events</span>
                            <span class="wc-number ml-auto">Upcoming</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Active Training Programmes Card -->
            <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
                <div class="widget-card widget-bg3">
                    <div class="wc-item">
                        <h4 class="wc-title">Active Training Programmes</h4>
                        <span class="wc-des">Delivery in progress</span>
                        <span class="wc-stats counter"><?php echo isset($dashboardData['metrics']['activeTrainings']) && $dashboardData['metrics']['activeTrainings'] !== null ? $dashboardData['metrics']['activeTrainings'] : '—'; ?></span>
                        <div class="progress wc-progress">
                               <div class="progress-bar wam-progress-bar" 
                                 role="progressbar" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"
                                   aria-label="Data pending"></div>
                        </div>
                        <span class="wc-progress-bx">
                            <span class="wc-change">Programmes</span>
                            <span class="wc-number ml-auto">Active</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Recent Publications Card -->
            <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
                <div class="widget-card widget-bg4">
                    <div class="wc-item">
                        <h4 class="wc-title">Recent Publications</h4>
                        <span class="wc-des">Knowledge outputs (30 days)</span>
                        <span class="wc-stats counter"><?php echo isset($dashboardData['metrics']['recentPublications']) && $dashboardData['metrics']['recentPublications'] !== null ? $dashboardData['metrics']['recentPublications'] : '—'; ?></span>
                        <div class="progress wc-progress">
                               <div class="progress-bar wam-progress-bar" 
                                 role="progressbar" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"
                                   aria-label="Data pending"></div>
                        </div>
                        <span class="wc-progress-bx">
                            <span class="wc-change">Outputs</span>
                            <span class="wc-number ml-auto">Published</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pending Membership Applications Card -->
            <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
                <div class="widget-card widget-bg5">
                    <div class="wc-item">
                        <h4 class="wc-title">Pending Membership Applications</h4>
                        <span class="wc-des">Review queue</span>
                        <span class="wc-stats counter"><?php echo isset($dashboardData['metrics']['pendingApplications']) && $dashboardData['metrics']['pendingApplications'] !== null ? $dashboardData['metrics']['pendingApplications'] : '—'; ?></span>
                        <div class="progress wc-progress">
                               <div class="progress-bar wam-progress-bar" 
                                 role="progressbar" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"
                                   aria-label="Data pending"></div>
                        </div>
                        <span class="wc-progress-bx">
                            <span class="wc-change">Applications</span>
                            <span class="wc-number ml-auto">Pending</span>
                        </span>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Statistics Cards End -->
        
        <div class="row">
            
            <!-- Profile Views Chart -->
            <div class="col-lg-8 m-b30">
                <div class="widget-box">
                    <div class="wc-title">
                        <h4>Network Visibility & Engagement</h4>
                    </div>
                    <div class="widget-inner">
                        <div id="chart-empty" class="wam-empty-state">
                            Analytics integration pending. Connect reporting to surface real engagement trends.
                        </div>
                        <canvas id="chart" class="wam-chart wam-hidden" width="100" height="45" aria-label="Website traffic chart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Notifications -->
            <div class="col-lg-4 m-b30">
                <div class="widget-box">
                    <div class="wc-title">
                        <h4>Leadership Actions</h4>
                    </div>
                    <div class="widget-inner">
                        <div class="noti-box-list">
                            <?php if (!empty($dashboardData['activity'])): ?>
                                <ul>
                                    <?php foreach ($dashboardData['activity'] as $activity): ?>
                                    <li>
                                        <span class="notification-icon <?php echo $activity['iconBg']; ?>">
                                            <i class="fa <?php echo $activity['iconClass']; ?>" aria-hidden="true"></i>
                                        </span>
                                        <span class="notification-text">
                                            <strong><?php echo sanitizeOutput($activity['title']); ?></strong>
                                            <span class="notification-detail"><?php echo sanitizeOutput($activity['detail']); ?></span>
                                        </span>
                                        <span class="notification-time">
                                            <button class="fa fa-close" aria-label="Dismiss notification"></button>
                                            <time datetime="<?php echo date('Y-m-d\TH:i'); ?>"><?php echo sanitizeOutput($activity['time']); ?></time>
                                        </span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="wam-empty-text">No activity updates yet. Connect workflow events to surface leadership actions.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Member Institutions -->
            <div class="col-lg-6 m-b30">
                <div class="widget-box">
                    <div class="wc-title">
                        <h4>Newest Member Institutions</h4>
                    </div>
                    <div class="widget-inner">
                        <div class="new-user-list">
                            <?php if (!empty($dashboardData['recentInstitutions'])): ?>
                                <ul>
                                    <?php foreach ($dashboardData['recentInstitutions'] as $institution): ?>
                                    <li>
                                        <span class="new-users-pic">
                                            <img src="<?php echo sanitizeOutput($institution['image']); ?>" alt="Institution logo"/>
                                        </span>
                                        <span class="new-users-text">
                                            <a href="#" class="new-users-name"><?php echo sanitizeOutput($institution['name']); ?></a>
                                            <span class="new-users-info"><?php echo sanitizeOutput($institution['meta']); ?></span>
                                        </span>
                                        <span class="new-users-btn">
                                            <a href="#" class="btn button-sm outline">View Institution</a>
                                        </span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="wam-empty-text">No new institutions yet. Registrations will appear once approved.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Registrations & Downloads -->
            <div class="col-lg-6 m-b30">
                <div class="widget-box">
                    <div class="wc-title">
                        <h4>Recent Registrations & Downloads</h4>
                    </div>
                    <div class="widget-inner">
                        <div class="orders-list">
                            <?php if (!empty($dashboardData['recentTransactions'])): ?>
                                <ul>
                                    <?php foreach ($dashboardData['recentTransactions'] as $transaction): ?>
                                    <li>
                                        <span class="orders-title">
                                            <a href="#" class="orders-title-name"><?php echo sanitizeOutput($transaction['title']); ?></a>
                                            <span class="orders-info"><?php echo sanitizeOutput($transaction['info']); ?> | <?php echo date('M d, Y'); ?></span>
                                        </span>
                                        <span class="orders-btn">
                                            <a href="#" class="btn button-sm <?php echo sanitizeOutput($transaction['statusClass']); ?>"><?php echo sanitizeOutput($transaction['status']); ?></a>
                                        </span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="wam-empty-text">No recent registrations or downloads yet. This will populate once data is available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Calendar Widget -->
            <div class="col-lg-12 m-b30">
                <div class="widget-box">
                    <div class="wc-title">
                        <h4>Programme Calendar</h4>
                    </div>
                    <div class="widget-inner">
                        <div id="calendar" aria-label="Event calendar"></div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</main>
<!-- Main Container End -->

<?php
// Page-specific JavaScript for charts and calendar
$calendarEvents = json_encode($dashboardData['events'], JSON_UNESCAPED_SLASHES);
$chartData = json_encode($dashboardData['chart'], JSON_UNESCAPED_SLASHES);

$inlineScript = <<<JAVASCRIPT
// Chart.js Configuration
(function() {
    'use strict';
    
    // Website Traffic Chart
    const ctx = document.getElementById('chart');
    const chartData = $chartData;
    if (ctx && typeof Chart !== 'undefined' && chartData && chartData.labels && chartData.labels.length) {
        const emptyState = document.getElementById('chart-empty');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        ctx.classList.remove('wam-hidden');
        const chart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    // FullCalendar Configuration
    if (typeof jQuery !== 'undefined' && jQuery.fn.fullCalendar) {
        jQuery(document).ready(function($) {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: new Date(),
                navLinks: true,
                weekNumbers: true,
                weekNumbersWithinDays: true,
                weekNumberCalculation: 'ISO',
                editable: true,
                eventLimit: true,
                events: $calendarEvents
            });
        });
    }
})();
JAVASCRIPT;

// Include modern footer component
include('includes/admin-footer.php');
?>
