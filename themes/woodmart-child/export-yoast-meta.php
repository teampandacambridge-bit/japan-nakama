<?php
if (! defined('WP_CLI')) {
    return;
}

// Input and output filenames in current directory
$input_csv  = getcwd() . '/input-post-ids.csv';
$output_csv = getcwd() . '/exported-meta-descriptions.csv';

if (! file_exists($input_csv)) {
    WP_CLI::error("Input CSV not found: {$input_csv}");
}

$in = fopen($input_csv, 'r');
if (! $in) {
    WP_CLI::error("Unable to open input CSV.");
}

$out = fopen($output_csv, 'w');
if (! $out) {
    WP_CLI::error("Unable to create output CSV.");
}

// Read header
$header = fgetcsv($in);
$header = array_map('trim', $header);

if (! in_array('post_id', $header, true)) {
    WP_CLI::error("Input CSV must contain a 'post_id' column.");
}

$idx = array_flip($header);

// Write output header
fputcsv($out, ['post_id', 'meta_description']);

$found = 0;
$missing = 0;

while (($row = fgetcsv($in)) !== false) {

    $post_id = (int)($row[$idx['post_id']] ?? 0);

    if ($post_id <= 0 || ! get_post($post_id)) {
        $missing++;
        continue;
    }

    $desc = get_post_meta($post_id, '_yoast_wpseo_metadesc', true);

    // Ensure clean text
    $desc = is_string($desc) ? trim($desc) : '';

    fputcsv($out, [$post_id, $desc]);
    $found++;
}

fclose($in);
fclose($out);

WP_CLI::success("Export complete. Found: {$found}. Missing posts: {$missing}. Output: {$output_csv}");
