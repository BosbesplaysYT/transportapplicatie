<?php

// Verwacht:
// $page
// $total_pages
// $page_url

if (!isset($page)) {
    $page = 1;
}
if (!isset($total_pages)) {
    $total_pages = 1;
}
if (!isset($page_url)) {
    $page_url = basename($_SERVER['PHP_SELF']);
}

// Juiste query-separator bepalen
$sep = (strpos($page_url, '?') !== false) ? '&' : '?';

echo '<div class="pagination">';

// Vorige
if ($page > 1) {
    $prev_page = $page - 1;
    echo "<a href='{$page_url}{$sep}page={$prev_page}'>&laquo;</a>";
}

// Helper: pagina-link printen
function pg_link($num, $page_url, $sep, $page) {
    $active = ($num == $page) ? " class='curPage'" : "";
    echo "<a href='{$page_url}{$sep}page={$num}'{$active}>{$num}</a>";
}

// --- ELLIPS LOGICA ---
// Toon altijd eerste pagina
if ($page > 3) {
    pg_link(1, $page_url, $sep, $page);

    if ($page > 4) {
        echo "<span class='ellipsis'>...</span>";
    }
}

// Pagina's rondom de huidige (2 links ervoor/erna)
$start = max(1, $page - 2);
$end = min($total_pages, $page + 2);

for ($i = $start; $i <= $end; $i++) {
    pg_link($i, $page_url, $sep, $page);
}

// Toon ellips vóór laatste pagina
if ($page < $total_pages - 2) {

    if ($page < $total_pages - 3) {
        echo "<span class='ellipsis'>...</span>";
    }

    pg_link($total_pages, $page_url, $sep, $page);
}

// Volgende
if ($page < $total_pages) {
    $next_page = $page + 1;
    echo "<a href='{$page_url}{$sep}page={$next_page}'>&raquo;</a>";
}

echo "</div>";
