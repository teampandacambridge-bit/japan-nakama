<?php

$heading     = $attributes['heading'] ?? '';
$subHeading  = $attributes['subHeading'] ?? '';
$selected    = $attributes['selectedPosts'] ?? [];

// Normalize values to integer IDs
$selected_ids = array_map('intval', (array) $selected);

// If no posts chosen → output nothing or fallback
if (empty($selected_ids)) {
	return '<section class="card-slider bg-white"><p>No posts selected.</p></section>';
}

$query = new WP_Query([
	'post_type'      => 'post',
	'post__in'       => $selected_ids,
	'orderby'        => 'post__in', // keep user-selected order
	'posts_per_page' => count($selected_ids),
]);

?>

<?php print_r($selected_id); ?>
<section class="card-slider bg-blue">

	<?php if ($heading) : ?>
		<h2><?php echo esc_html($heading); ?></h2>
	<?php endif; ?>

	<?php if ($subHeading) : ?>
		<p><?php echo esc_html($subHeading); ?></p>
	<?php endif; ?>

	<div id="card-slider-three" class="swiper-container">
		<div class="swiper-wrapper three-cards ">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<div class="swiper-slide">
					<a href="<?php the_permalink(); ?>" class="post-card">

						<div class="image">
							<?php echo get_the_post_thumbnail(get_the_ID(), 'small'); ?>
						</div>

						<div class="text">
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html(mb_substr(get_the_excerpt(), 0, 50)) . '…'; ?></p>
						</div>

					</a>
				</div>
			<?php endwhile; ?>

		</div>
		<div class="swiper-pagination-three"></div>
	</div>

</section>

<?php wp_reset_postdata(); ?>