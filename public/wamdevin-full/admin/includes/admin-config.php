<?php
/**
 * WAMDEVIN Admin Dashboard - Configuration
 * 
 * Central configuration file for admin panel
 * Defines constants, settings, and helper functions
 * 
 * @version 2.0.0
 * @since February 2026
 */

// Prevent direct access
if (!defined('ADMIN_INIT')) {
    define('ADMIN_INIT', true);
}

// Load shared database helpers for real dashboard data
require_once __DIR__ . '/../../includes/db-config.php';

/**
 * Safe dashboard connection that does not terminate the page
 * @return PDO|null
 */
function getDashboardConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            )
        );

        return $pdo;
    } catch (PDOException $e) {
        error_log('Dashboard DB connection error: ' . $e->getMessage());
        return null;
    }
}

// ==============================================
// SYSTEM CONFIGURATION
// ==============================================

// Base Paths
define('ADMIN_PATH', dirname(__DIR__));
define('ADMIN_INCLUDES', ADMIN_PATH . '/includes');
define('ADMIN_ASSETS', ADMIN_PATH . '/assets');

// URLs
define('SITE_URL', '../');
define('ADMIN_URL', '.');

// ==============================================
// ADMIN SETTINGS
// ==============================================

// Dashboard Configuration
define('SITE_NAME', 'WAMDEVIN');
define('ADMIN_TITLE', 'WAMDEVIN Admin Dashboard');
define('ADMIN_LOGO_DESKTOP', '../assets/images/logo-white.png');
define('ADMIN_LOGO_MOBILE', '../assets/images/logo-white.png');
define('ADMIN_LOGO_SIDEBAR', '../assets/images/logo.png');

// Version
define('ADMIN_VERSION', '2.0.0');

// Date Format
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');

// ==============================================
// HELPER FUNCTIONS
// ==============================================

/**
 * Get current page name
 * @return string
 */
function getCurrentPage() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page;
}

/**
 * Check if current page is active
 * @param string $pageName
 * @return string 'active' CSS class if match
 */
function isActivePage($pageName) {
    return (getCurrentPage() === $pageName) ? 'active' : '';
}

/**
 * Format date
 * @param string $date
 * @param string $format
 * @return string
 */
function formatDate($date, $format = DATE_FORMAT) {
    try {
        $dateTime = new DateTime($date);
        return $dateTime->format($format);
    } catch (Exception $e) {
        return $date;
    }
}

/**
 * Sanitize output
 * @param string $text
 * @return string
 */
function sanitizeOutput($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if a table exists
 * @param PDO $db
 * @param string $table
 * @return bool
 */
function adminTableExists(PDO $db, $table) {
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = :table");
        $stmt->execute([':table' => $table]);
        return (int)$stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Check if a column exists in a table
 * @param PDO $db
 * @param string $table
 * @param string $column
 * @return bool
 */
function adminColumnExists(PDO $db, $table, $column) {
    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = :table AND column_name = :column");
        $stmt->execute([':table' => $table, ':column' => $column]);
        return (int)$stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Safe scalar query helper
 * @param PDO $db
 * @param string $sql
 * @param array $params
 * @param mixed $default
 * @return mixed
 */
function adminScalar(PDO $db, $sql, $params = [], $default = null) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    } catch (Exception $e) {
        return $default;
    }
}

/**
 * Safe rows query helper
 * @param PDO $db
 * @param string $sql
 * @param array $params
 * @return array
 */
function adminRows(PDO $db, $sql, $params = []) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Dashboard data provider (placeholder until database integration)
 * @return array
 */
function getDashboardData() {
    $data = [
        'metrics' => [
            'memberInstitutions' => null,
            'upcomingEvents' => null,
            'activeTrainings' => null,
            'recentPublications' => null,
            'pendingApplications' => null
        ],
        'dbError' => false,
        'activity' => [],
        'recentInstitutions' => [],
        'recentTransactions' => [],
        'events' => [],
        'chart' => [
            'labels' => [],
            'datasets' => []
        ]
    ];

    try {
        $db = getDashboardConnection();
        if (!$db) {
            $data['dbError'] = true;
            return $data;
        }

        // Member institution metrics
        if (adminTableExists($db, 'institution_members')) {
            $hasDeletedAt = adminColumnExists($db, 'institution_members', 'deleted_at');
            $hasStatus = adminColumnExists($db, 'institution_members', 'status');

            $memberSql = "SELECT COUNT(*) FROM institution_members WHERE 1=1";
            $memberParams = [];
            if ($hasDeletedAt) {
                $memberSql .= " AND deleted_at IS NULL";
            }
            if ($hasStatus) {
                $memberSql .= " AND status = :status";
                $memberParams[':status'] = 'verified';
            }

            $pendingSql = "SELECT COUNT(*) FROM institution_members WHERE 1=1";
            $pendingParams = [];
            if ($hasDeletedAt) {
                $pendingSql .= " AND deleted_at IS NULL";
            }
            if ($hasStatus) {
                $pendingSql .= " AND status = :status";
                $pendingParams[':status'] = 'pending';
            } else {
                $pendingSql .= " AND 1=0";
            }

            $data['metrics']['memberInstitutions'] = (int)adminScalar($db, $memberSql, $memberParams, 0);
            $data['metrics']['pendingApplications'] = (int)adminScalar($db, $pendingSql, $pendingParams, 0);

            $countryExpr = adminColumnExists($db, 'institution_members', 'country') ? 'country' : "'N/A'";
            $nameExpr = adminColumnExists($db, 'institution_members', 'institution_name') ? 'institution_name' : "CONCAT('Institution #', id)";
            $createdExpr = adminColumnExists($db, 'institution_members', 'created_at') ? 'created_at' : 'id';
            $recentInstitutionsSql = "SELECT {$nameExpr} AS institution_name, {$countryExpr} AS country FROM institution_members ORDER BY {$createdExpr} DESC LIMIT 3";
            foreach (adminRows($db, $recentInstitutionsSql) as $row) {
                $data['recentInstitutions'][] = [
                    'name' => $row['institution_name'],
                    'meta' => 'Member Institution - ' . $row['country'],
                    'image' => ADMIN_LOGO_SIDEBAR
                ];
            }
        }

        // Events metrics and calendar
        if (adminTableExists($db, 'events')) {
            $hasStartDate = adminColumnExists($db, 'events', 'start_date');
            $hasStatus = adminColumnExists($db, 'events', 'status');
            if ($hasStartDate) {
                $eventCountSql = "SELECT COUNT(*) FROM events WHERE start_date >= CURDATE() AND start_date <= DATE_ADD(CURDATE(), INTERVAL 90 DAY)";
                if ($hasStatus) {
                    $eventCountSql .= " AND status != 'cancelled'";
                }
                $data['metrics']['upcomingEvents'] = (int)adminScalar($db, $eventCountSql, [], 0);

                $endExpr = adminColumnExists($db, 'events', 'end_date') ? 'end_date' : 'NULL';
                $statusExpr = $hasStatus ? 'status' : "'planned'";
                $titleExpr = adminColumnExists($db, 'events', 'title') ? 'title' : "CONCAT('Event #', id)";
                $eventsSql = "SELECT {$titleExpr} AS title, start_date, {$endExpr} AS end_date, {$statusExpr} AS status FROM events WHERE start_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY) ORDER BY start_date ASC LIMIT 50";
                foreach (adminRows($db, $eventsSql) as $row) {
                    $data['events'][] = [
                        'title' => $row['title'],
                        'start' => $row['start_date'],
                        'end' => $row['end_date'] ?: null,
                        'color' => getEventStatusColor($row['status'])
                    ];
                }
            }
        }

        // Training metric
        if (adminTableExists($db, 'trainings')) {
            $hasStatus = adminColumnExists($db, 'trainings', 'status');
            $hasStartDate = adminColumnExists($db, 'trainings', 'start_date');
            $hasEndDate = adminColumnExists($db, 'trainings', 'end_date');
            $trainingSql = "SELECT COUNT(*) FROM trainings WHERE 1=1";
            if ($hasStatus) {
                $trainingSql .= " AND status = 'active'";
            }
            if ($hasStartDate) {
                $trainingSql .= " AND start_date <= CURDATE()";
            }
            if ($hasEndDate) {
                $trainingSql .= " AND (end_date IS NULL OR end_date >= CURDATE())";
            }
            $data['metrics']['activeTrainings'] = (int)adminScalar($db, $trainingSql, [], 0);
        }

        // Publications metric
        if (adminTableExists($db, 'publications')) {
            $hasStatus = adminColumnExists($db, 'publications', 'status');
            $hasPublishedAt = adminColumnExists($db, 'publications', 'published_at');
            $pubSql = "SELECT COUNT(*) FROM publications WHERE 1=1";
            if ($hasStatus) {
                $pubSql .= " AND status = 'published'";
            }
            if ($hasPublishedAt) {
                $pubSql .= " AND published_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
            }
            $data['metrics']['recentPublications'] = (int)adminScalar($db, $pubSql, [], 0);
        }

        // Activity feed and chart from activity logs
        if (adminTableExists($db, 'activity_logs')) {
            $hasCreatedAt = adminColumnExists($db, 'activity_logs', 'created_at');
            $createdExpr = $hasCreatedAt ? 'al.created_at' : 'NOW()';
            $activityQuery = "
                SELECT al.action, al.details, {$createdExpr} AS created_at, al.user_type,
                       au.admin_name, im.institution_name
                FROM activity_logs al
                LEFT JOIN admin_users au ON al.user_type = 'admin' AND al.user_id = au.id
                LEFT JOIN institution_members im ON al.user_type = 'member' AND al.user_id = im.id
                ORDER BY {$createdExpr} DESC
                LIMIT 6
            ";

            foreach (adminRows($db, $activityQuery) as $row) {
                $mapping = getActivityPresentation($row['action']);
                $name = '';
                if (!empty($row['admin_name'])) {
                    $name = 'Admin: ' . $row['admin_name'];
                } elseif (!empty($row['institution_name'])) {
                    $name = 'Institution: ' . $row['institution_name'];
                }
                $detail = !empty($row['details']) ? $row['details'] : ($name ?: 'Activity recorded');
                $data['activity'][] = [
                    'iconClass' => $mapping['icon'],
                    'iconBg' => $mapping['bg'],
                    'title' => $mapping['title'],
                    'detail' => $detail,
                    'time' => formatRelativeTime($row['created_at'])
                ];
            }

            // chart
            if ($hasCreatedAt) {
                $chartStart = (new DateTime('first day of -11 months'))->format('Y-m-01 00:00:00');
                $chartQuery = "
                    SELECT DATE_FORMAT(created_at, '%Y-%m') as period,
                           SUM(CASE WHEN action = 'login' AND user_type = 'member' THEN 1 ELSE 0 END) as member_logins,
                           SUM(CASE WHEN action = 'login' AND user_type = 'admin' THEN 1 ELSE 0 END) as admin_logins
                    FROM activity_logs
                    WHERE created_at >= :start
                    GROUP BY period
                    ORDER BY period
                ";
                $chartRows = adminRows($db, $chartQuery, [':start' => $chartStart]);
                $labels = [];
                $memberSeries = [];
                $adminSeries = [];
                $dataByPeriod = [];
                $totalLogins = 0;
                foreach ($chartRows as $row) {
                    $dataByPeriod[$row['period']] = $row;
                    $totalLogins += (int)$row['member_logins'] + (int)$row['admin_logins'];
                }
                if ($totalLogins > 0) {
                    for ($i = 11; $i >= 0; $i--) {
                        $period = (new DateTime("first day of -{$i} months"))->format('Y-m');
                        $labels[] = (new DateTime("{$period}-01"))->format('M Y');
                        $memberSeries[] = isset($dataByPeriod[$period]) ? (int)$dataByPeriod[$period]['member_logins'] : 0;
                        $adminSeries[] = isset($dataByPeriod[$period]) ? (int)$dataByPeriod[$period]['admin_logins'] : 0;
                    }
                    $data['chart'] = [
                        'labels' => $labels,
                        'datasets' => [
                            ['label' => 'Member Logins', 'data' => $memberSeries, 'borderColor' => '#1766a2', 'backgroundColor' => 'rgba(23, 102, 162, 0.1)', 'tension' => 0.4, 'fill' => true],
                            ['label' => 'Admin Logins', 'data' => $adminSeries, 'borderColor' => '#27ae60', 'backgroundColor' => 'rgba(39, 174, 96, 0.1)', 'tension' => 0.4, 'fill' => true]
                        ]
                    ];
                }
            }
        }

        // Recent transactions from activity logs (registration/enrollment/download actions)
        if (adminTableExists($db, 'activity_logs')) {
            $txnSql = "
                SELECT action, details, created_at
                FROM activity_logs
                WHERE action IN ('event_registration', 'training_enrollment', 'publication_download', 'register')
                ORDER BY created_at DESC
                LIMIT 4
            ";
            $txnRows = adminRows($db, $txnSql);
            foreach ($txnRows as $txn) {
                $status = ($txn['action'] === 'event_registration' || $txn['action'] === 'training_enrollment') ? 'Confirmed' : 'Completed';
                $statusClass = ($status === 'Confirmed') ? 'green' : 'green';
                if ($txn['action'] === 'register') {
                    $status = 'Pending';
                    $statusClass = 'yellow';
                }
                $data['recentTransactions'][] = [
                    'title' => ucwords(str_replace('_', ' ', $txn['action'])),
                    'info' => !empty($txn['details']) ? $txn['details'] : 'Dashboard activity',
                    'status' => $status,
                    'statusClass' => $statusClass
                ];
            }
        }

    } catch (Exception $e) {
        error_log('Dashboard data error: ' . $e->getMessage());
    }

    return $data;
}

/**
 * Format relative time from timestamp
 * @param string $dateTime
 * @return string
 */
function formatRelativeTime($dateTime) {
    $timestamp = strtotime($dateTime);
    if (!$timestamp) {
        return '—';
    }

    $diff = time() - $timestamp;
    if ($diff < 60) {
        return 'just now';
    }
    if ($diff < 3600) {
        return floor($diff / 60) . ' min';
    }
    if ($diff < 86400) {
        return floor($diff / 3600) . ' hr';
    }
    if ($diff < 604800) {
        return floor($diff / 86400) . ' days';
    }

    return date('M d', $timestamp);
}

/**
 * Map activity actions to icons and labels
 * @param string $action
 * @return array
 */
function getActivityPresentation($action) {
    $map = [
        'login' => ['title' => 'Login success', 'icon' => 'fa-sign-in', 'bg' => 'dashbg-green'],
        'failed_login' => ['title' => 'Login attempt failed', 'icon' => 'fa-exclamation-circle', 'bg' => 'dashbg-red'],
        'logout' => ['title' => 'Logout recorded', 'icon' => 'fa-sign-out', 'bg' => 'dashbg-gray'],
        'email_verified' => ['title' => 'Email verified', 'icon' => 'fa-check-circle', 'bg' => 'dashbg-primary'],
        'register' => ['title' => 'New institution registered', 'icon' => 'fa-user-plus', 'bg' => 'dashbg-green'],
        'forgot_password_request' => ['title' => 'Password reset requested', 'icon' => 'fa-key', 'bg' => 'dashbg-yellow'],
        'password_reset' => ['title' => 'Password reset completed', 'icon' => 'fa-unlock-alt', 'bg' => 'dashbg-primary'],
        'account_suspended' => ['title' => 'Account suspended', 'icon' => 'fa-ban', 'bg' => 'dashbg-red']
    ];

    if (isset($map[$action])) {
        return $map[$action];
    }

    return [
        'title' => ucwords(str_replace('_', ' ', $action)),
        'icon' => 'fa-info-circle',
        'bg' => 'dashbg-gray'
    ];
}

/**
 * Map event status to calendar color
 * @param string $status
 * @return string
 */
function getEventStatusColor($status) {
    $map = [
        'planned' => '#1766a2',
        'confirmed' => '#27ae60',
        'completed' => '#9b59b6',
        'cancelled' => '#e74c3c'
    ];

    return isset($map[$status]) ? $map[$status] : '#1766a2';
}

/**
 * Provide mission-aligned intro copy per admin page
 * @param string $pageKey
 * @return array|null
 */
function getAdminPageIntro($pageKey) {
    if ($pageKey === 'dashboard' || $pageKey === 'index') {
        return null;
    }

    $introMap = [
        'member-institutions' => [
            'title' => 'Institution Registry & Standards',
            'lead' => 'Maintain the institutional registry that anchors regional collaboration and public sector excellence.',
            'points' => [
                'Review applications and accreditation readiness',
                'Update leadership contacts and institutional profiles',
                'Track renewals, engagement health, and compliance'
            ]
        ],
        'events' => [
            'title' => 'Programme Delivery & Convenings',
            'lead' => 'Coordinate flagship programmes and convenings that advance the WAMDEVIN agenda.',
            'points' => [
                'Approve event calendars and delivery plans',
                'Align logistics, partners, and delegate readiness',
                'Capture outcomes for reporting and learning'
            ]
        ],
        'trainings' => [
            'title' => 'Leadership Development Pipeline',
            'lead' => 'Deliver training programmes that scale institutional capability across the region.',
            'points' => [
                'Prioritize learning pathways and cohort readiness',
                'Coordinate facilitators and quality assurance',
                'Track participation, outcomes, and impact'
            ]
        ],
        'publications' => [
            'title' => 'Knowledge & Evidence Outputs',
            'lead' => 'Curate evidence that shapes policy, practice, and institutional learning.',
            'points' => [
                'Manage submissions and editorial review flows',
                'Schedule releases and stakeholder distribution',
                'Monitor downloads and evidence uptake'
            ]
        ],
        'research-projects' => [
            'title' => 'Regional Research Portfolio',
            'lead' => 'Steer multi-country research that informs governance and reform.',
            'points' => [
                'Align partners and milestones across countries',
                'Track deliverables, risks, and reporting',
                'Translate findings into action'
            ]
        ],
        'consultancy' => [
            'title' => 'Advisory & Institutional Support',
            'lead' => 'Manage consultancy engagements that translate strategy into outcomes.',
            'points' => [
                'Qualify new requests and scope delivery',
                'Monitor proposals, approvals, and engagement health',
                'Capture outcomes and client feedback'
            ]
        ],
        'users' => [
            'title' => 'Leadership Community & Governance',
            'lead' => 'Build a trusted admin community that supports the WAMDEVIN mission.',
            'points' => [
                'Role-based access aligned to governance mandates',
                'Onboarding, offboarding, and credential stewardship',
                'Audit trails and compliance readiness'
            ]
        ],
        'settings' => [
            'title' => 'Governance & Standards',
            'lead' => 'Set the standards that protect the network and enable accountable delivery.',
            'points' => [
                'Brand identity and communications governance',
                'Workflow, notifications, and approvals',
                'Security policies and access controls'
            ]
        ],
        'basic-calendar' => [
            'title' => 'Programme Milestone Alignment',
            'lead' => 'Keep regional programmes aligned to delivery milestones and convenings.',
            'points' => [
                'Coordinate programme windows and lead times',
                'Reduce scheduling conflicts across partners',
                'Support leadership readiness planning'
            ]
        ],
        'list-view-calendar' => [
            'title' => 'Programme Milestone Alignment',
            'lead' => 'Track upcoming convenings and delivery milestones across the network.',
            'points' => [
                'Review calendar priorities and dependencies',
                'Coordinate partner availability and resources',
                'Ensure readiness for delivery'
            ]
        ],
        'mailbox' => [
            'title' => 'Stakeholder Communications',
            'lead' => 'Manage official correspondence and stakeholder updates with clarity.',
            'points' => [
                'Track inbound requests and responses',
                'Coordinate messaging with programme teams',
                'Maintain a clear communications trail'
            ]
        ],
        'mailbox-read' => [
            'title' => 'Stakeholder Communications',
            'lead' => 'Review stakeholder messages and respond with mission-aligned clarity.',
            'points' => [
                'Validate requests and route to owners',
                'Keep correspondence aligned to policy',
                'Document decisions and next steps'
            ]
        ],
        'mailbox-compose' => [
            'title' => 'Stakeholder Communications',
            'lead' => 'Compose updates that reinforce trust and transparency.',
            'points' => [
                'Deliver clear programme updates',
                'Align messages with leadership priorities',
                'Maintain professional tone and records'
            ]
        ],
        'courses' => [
            'title' => 'Learning Portfolio Governance',
            'lead' => 'Manage learning assets that strengthen institutional capability.',
            'points' => [
                'Align course offerings with regional priorities',
                'Track quality, facilitators, and outcomes',
                'Ensure consistency across member institutes'
            ]
        ],
        'teacher-profile' => [
            'title' => 'Facilitator Leadership',
            'lead' => 'Elevate facilitator profiles that embody WAMDEVIN standards.',
            'points' => [
                'Highlight expertise and delivery readiness',
                'Align facilitators to priority programmes',
                'Ensure visibility across the network'
            ]
        ],
        'user-profile' => [
            'title' => 'Leadership Profile',
            'lead' => 'Maintain profiles that reinforce accountability and governance.',
            'points' => [
                'Keep roles and responsibilities current',
                'Align profiles with programme oversight',
                'Ensure visibility of leadership ownership'
            ]
        ],
        'review' => [
            'title' => 'Quality Assurance',
            'lead' => 'Review submissions to uphold WAMDEVIN standards and impact.',
            'points' => [
                'Prioritize items requiring executive review',
                'Track decisions and follow-up actions',
                'Maintain compliance and audit readiness'
            ]
        ],
        'bookmark' => [
            'title' => 'Operational Shortcuts',
            'lead' => 'Organize priority items that support delivery readiness.',
            'points' => [
                'Pin high-priority resources',
                'Align quick access with leadership needs',
                'Reduce time to action'
            ]
        ],
        'add-listing' => [
            'title' => 'Content Publishing',
            'lead' => 'Publish new listings that reflect WAMDEVIN priorities.',
            'points' => [
                'Ensure accuracy and compliance',
                'Align content with programme schedules',
                'Maintain professional presentation'
            ]
        ]
    ];

    if (isset($introMap[$pageKey])) {
        return $introMap[$pageKey];
    }

    return [
        'title' => 'Mission Alignment',
        'lead' => 'Support WAMDEVIN delivery with clear governance, collaboration, and impact focus.',
        'points' => [
            'Maintain clarity across stakeholders',
            'Align actions with regional priorities',
            'Document outcomes and accountability'
        ]
    ];
}

/**
 * Get user initials (placeholder function)
 * @param string $name
 * @return string
 */
function getUserInitials($name) {
    $words = explode(' ', $name);
    $initials = '';
    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }
    return substr($initials, 0, 2);
}

/**
 * Resolve status to button color class
 * @param string $status
 * @return string
 */
function getStatusButtonClass($status) {
    $status = strtolower(trim((string)$status));
    if (in_array($status, ['confirmed', 'completed', 'active', 'verified', 'published', 'approved'], true)) {
        return 'green';
    }
    if (in_array($status, ['pending', 'draft', 'in_review', 'queued'], true)) {
        return 'yellow';
    }
    if (in_array($status, ['cancelled', 'rejected', 'inactive', 'failed', 'suspended'], true)) {
        return 'red';
    }
    return 'blue';
}

/**
 * Build pagination metadata
 * @param int $totalItems
 * @param int $currentPage
 * @param int $perPage
 * @return array
 */
function buildPagination($totalItems, $currentPage, $perPage) {
    $totalItems = max(0, (int)$totalItems);
    $perPage = max(1, (int)$perPage);
    $totalPages = max(1, (int)ceil($totalItems / $perPage));
    $currentPage = max(1, min((int)$currentPage, $totalPages));

    return [
        'totalItems' => $totalItems,
        'perPage' => $perPage,
        'totalPages' => $totalPages,
        'currentPage' => $currentPage,
        'offset' => ($currentPage - 1) * $perPage,
        'hasPrev' => $currentPage > 1,
        'hasNext' => $currentPage < $totalPages,
        'prevPage' => max(1, $currentPage - 1),
        'nextPage' => min($totalPages, $currentPage + 1)
    ];
}
