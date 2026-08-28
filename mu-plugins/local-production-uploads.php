<?php
/**
 * Plugin Name: Local: serve uploads from production
 * Description: Rewrites upload URLs to the production site so the local
 *              environment doesn't need a copy of wp-content/uploads.
 *              Local files, when present, still win.
 * Author:      Japan Nakama
 *
 * This is a LOCAL DEVELOPMENT helper. It must never run on production.
 *
 * The .htaccess rule ("Production uploads fallback") does the same job at the
 * web-server level and covers every request, including direct hits. This
 * mu-plugin additionally rewrites URLs in generated markup (srcset, etc.), so
 * pages reference production directly rather than issuing a local request that
 * then redirects.
 *
 * Delete this file to disable.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const JN_PRODUCTION_URL = 'https://www.japannakama.co.uk';

/**
 * Only ever active on the local host. Guards against this being copied to
 * staging or production by accident.
 */
function jn_is_local_env(): bool {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( (string) $_SERVER['HTTP_HOST'] ) : '';

	return str_ends_with( $host, '.local' ) || 'localhost' === $host;
}

/**
 * Is the file actually present in the local uploads folder?
 * If it is, we leave the URL alone so local edits and new uploads win.
 */
function jn_upload_exists_locally( string $relative_path ): bool {
	$uploads = wp_get_upload_dir();

	return '' !== $relative_path && file_exists( $uploads['basedir'] . '/' . ltrim( $relative_path, '/' ) );
}

/**
 * Point the uploads base URL at production unless the file exists locally.
 */
add_filter(
	'wp_get_attachment_url',
	function ( $url ) {
		if ( ! jn_is_local_env() ) {
			return $url;
		}

		$uploads = wp_get_upload_dir();

		if ( ! str_starts_with( (string) $url, $uploads['baseurl'] ) ) {
			return $url;
		}

		$relative = substr( $url, strlen( $uploads['baseurl'] ) );

		if ( jn_upload_exists_locally( $relative ) ) {
			return $url;
		}

		return JN_PRODUCTION_URL . '/wp-content/uploads' . $relative;
	},
	10,
	1
);

/**
 * Responsive images: srcset entries are built from local file metadata, so
 * rewrite each candidate that has no local file.
 */
add_filter(
	'wp_calculate_image_srcset',
	function ( $sources ) {
		if ( ! jn_is_local_env() || ! is_array( $sources ) ) {
			return $sources;
		}

		$uploads = wp_get_upload_dir();

		foreach ( $sources as $key => $source ) {
			$url = $source['url'] ?? '';

			if ( ! str_starts_with( $url, $uploads['baseurl'] ) ) {
				continue;
			}

			$relative = substr( $url, strlen( $uploads['baseurl'] ) );

			if ( jn_upload_exists_locally( $relative ) ) {
				continue;
			}

			$sources[ $key ]['url'] = JN_PRODUCTION_URL . '/wp-content/uploads' . $relative;
		}

		return $sources;
	},
	10,
	1
);
