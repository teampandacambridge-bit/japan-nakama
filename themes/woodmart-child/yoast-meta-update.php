<?php
if (! defined('WP_CLI')) {
    return;
}

// Fixed CSV file name in current directory
$csv_path = getcwd() . '/yoast-meta.csv';

if (! file_exists($csv_path)) {
    WP_CLI::error("CSV file not found. Expected: {$csv_path}");
}

$fh = fopen($csv_path, 'r');
if (! $fh) {
    WP_CLI::error("Unable to open CSV file.");
}

$header = fgetcsv($fh);
if (! $header) {
    WP_CLI::error("CSV is empty.");
}

$header = array_map('trim', $header);
$idx = array_flip($header);

// Only post_id and meta_description are required now
foreach (['post_id', 'meta_description'] as $col) {
    if (! isset($idx[$col])) {
        WP_CLI::error("CSV missing required column: {$col}");
    }
}

$updated = 0;
$skipped = 0;

while (($row = fgetcsv($fh)) !== false) {

    $post_id = (int)($row[$idx['post_id']] ?? 0);
    if ($post_id <= 0 || ! get_post($post_id)) {
        $skipped++;
        continue;
    }

    $desc = trim((string)($row[$idx['meta_description']] ?? ''));

    // Update ONLY Yoast meta description
    if ($desc !== '') {
        update_post_meta($post_id, '_yoast_wpseo_metadesc', $desc);
        $updated++;
    } else {
        $skipped++;
    }
}

fclose($fh);

WP_CLI::success("Completed. Meta descriptions updated: {$updated}. Skipped: {$skipped}.");
