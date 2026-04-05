<?php
$pageTitle = 'Calendar - WAMDEVIN Admin';
$pageDescription = 'Track regional events and programme milestones across the network';
$currentPage = 'events';
$useCalendar = true;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Event Calendar</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Calendar</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>WAMDEVIN Programme Calendar</h4>
            </div>
            <div class="widget-inner">
                <p>Keep leadership programmes, convenings, and delivery milestones aligned to regional priorities.</p>
                <div id="calendar" aria-label="Event calendar"></div>
            </div>
        </div>
    </div>
</main>

<?php
$dashboardData = getDashboardData();
$calendarEvents = json_encode($dashboardData['events'], JSON_UNESCAPED_SLASHES);
$inlineScript = <<<JAVASCRIPT
(function() {
    'use strict';
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
                editable: false,
                eventLimit: true,
                events: $calendarEvents
            });
        });
    }
})();
JAVASCRIPT;
include('includes/admin-footer.php');
?>
