<?php
/**
 * WAMDEVIN Admin Page Intro
 * Renders mission-aligned context blocks for admin pages.
 */

$pageKey = isset($currentPage) ? $currentPage : getCurrentPage();
$intro = getAdminPageIntro($pageKey);

if (empty($intro)) {
    return;
}
?>
<div class="wam-page-intro">
    <div class="wam-page-intro__header">
        <span class="wam-page-intro__eyebrow">Mission Focus</span>
        <h5 class="wam-page-intro__title"><?php echo sanitizeOutput($intro['title']); ?></h5>
    </div>
    <p class="wam-page-intro__lead"><?php echo sanitizeOutput($intro['lead']); ?></p>
    <ul class="wam-page-intro__list">
        <?php foreach ($intro['points'] as $point): ?>
            <li><?php echo sanitizeOutput($point); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
