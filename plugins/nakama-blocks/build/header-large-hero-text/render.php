<?php
// Block attributes
$heading_1 = $attributes['heading_1'] ?? '';
$heading_2 = $attributes['heading_2'] ?? '';
$subHeading = $attributes['subHeading' ?? ''];

// Featured image
$hero_image_id     = get_post_thumbnail_id();
$hero_image_url    = wp_get_attachment_image_url($hero_image_id, 'full');
$hero_image_srcset = wp_get_attachment_image_srcset($hero_image_id, 'full');
$hero_image_sizes  = '(max-width: 900px) 100vw, 1200px';
$alt_text          = get_post_meta($hero_image_id, '_wp_attachment_image_alt', true);
?>

<header id="page-header" class="container container-md">

	<img
		src="<?php echo esc_url($hero_image_url); ?>"
		srcset="<?php echo esc_attr($hero_image_srcset); ?>"
		sizes="<?php echo esc_attr($hero_image_sizes); ?>"
		alt="<?php echo esc_attr($alt_text); ?>"
		loading="eager"
		class="no-lazy">



	<h1>
		<?php echo esc_html($heading_1); ?>
		<?php if (!empty($heading_2)) : ?>
			<span><?php echo esc_html($heading_2); ?></span>
		<?php endif; ?>
	</h1>

	<p class="header-lead">
		<?php echo esc_html($subHeading); ?>
	</p>

	<div class="bread-time">

		<?php
		$home_url  = home_url('/');
		$current_id = get_the_ID();
		$parent_id  = wp_get_post_parent_id($current_id);
		?>

		<nav class="bread-links" aria-label="Breadcrumb">
			<a href="<?php echo esc_url($home_url); ?>">Home</a>

			<?php if ($parent_id): ?>
				&gt;
				<a href="<?php echo esc_url(get_permalink($parent_id)); ?>">
					<?php echo esc_html(get_the_title($parent_id)); ?>
				</a>
			<?php endif; ?>

			&gt;
			<span><?php the_title(); ?></span>
		</nav>

		<script type="application/ld+json">
			<?php
			$position = 1;
			$items    = [];

			// Home
			$items[] = [
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => 'Home',
				'item'     => $home_url,
			];

			// Parent page (if exists)
			if ($parent_id) {
				$items[] = [
					'@type'    => 'ListItem',
					'position' => $position++,
					'name'     => get_the_title($parent_id),
					'item'     => get_permalink($parent_id),
				];
			}

			// Current page
			$items[] = [
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => get_the_title(),
				'item'     => get_permalink(),
			];

			echo wp_json_encode([
				'@context'        => 'https://schema.org',
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $items,
			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			?>
		</script>



		<time datetime="<?php echo get_the_modified_time('c'); ?>">
			last updated: <?php echo get_the_modified_time('jS F Y'); ?>
		</time>
	</div>





</header>