<?php

$heading        = $attributes['heading'] ?? '';
$cost           = $attributes['cost'] ?? '';
$address        = $attributes['address'] ?? '';
$hours          = $attributes['hours'] ?? '';
$items          = $attributes['items'] ?? [];
$bullets        = $attributes['bullets'] ?? [];
$bulletHeading  = $attributes['bulletHeading'] ?? '';
$cta            = $attributes['cta'] ?? ['text' => '', 'url' => ''];

// Ensure valid arrays
if (! is_array($items)) {
	$items = [];
}
if (! is_array($bullets)) {
	$bullets = [];
}

// /**
//  * Build JSON-LD structured data
//  */
// $schema = [
// 	'@context'  => 'https://schema.org',
// 	'@type'     => 'TouristAttraction',
// 	'name'      => $heading,
// 	'description' => ! empty($items)
// 		? implode(
// 			'; ',
// 			array_map(
// 				fn($i) => trim(($i['heading'] ?? '') . ': ' . ($i['description'] ?? '')),
// 				$items
// 			)
// 		)
// 		: null,
// 	'address'   => ! empty($address)
// 		? [
// 			'@type'          => 'PostalAddress',
// 			'streetAddress'  => strip_tags($address),
// 		]
// 		: null,
// 	'openingHours' => ! empty($hours)
// 		? [wp_strip_all_tags(str_replace(["\r", "\n"], ' ', $hours))]
// 		: null,
// 	'offers'    => ! empty($cost)
// 		? [
// 			'@type'         => 'Offer',
// 			'price'         => preg_replace('/[^0-9.]/', '', $cost),
// 			'priceCurrency' => 'GBP',
// 			'availability'  => 'https://schema.org/InStock',
// 		]
// 		: null,
// 	'keywords'  => ! empty($bullets)
// 		? array_values(
// 			array_filter(
// 				array_map(
// 					fn($b) => $b['text'] ?? '',
// 					$bullets
// 				)
// 			)
// 		)
// 		: null,
// 	'url'       => ! empty($cta['url']) ? esc_url_raw($cta['url']) : null,
// ];

// $schema = array_filter($schema);
// 
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'post-overview-render']); ?>>

	<?php if (! empty($heading)) : ?>
		<h2><?php echo esc_html($heading); ?></h2>
	<?php else : ?>
		<h2><?php esc_html_e('Attraction Overview', 'attraction-overview'); ?></h2>
	<?php endif; ?>

	<dl class="overview-meta">

		<!-- Address -->
		<?php if (! empty($address)) : ?>
			<dt><?php esc_html_e('Address:', 'attraction-overview'); ?></dt>
			<dd><?php echo wp_kses_post($address); ?></dd>
		<?php endif; ?>

		<!-- Cost -->
		<?php if (! empty($cost)) : ?>
			<dt><?php esc_html_e('Admission:', 'attraction-overview'); ?></dt>
			<dd><?php echo wp_kses_post($cost); ?></dd>
		<?php endif; ?>

		<!-- Hours -->
		<?php if (! empty($hours)) : ?>
			<dt><?php esc_html_e('Hours:', 'attraction-overview'); ?></dt>
			<dd class="overview-hours">
				<?php
				// Allow line breaks and safe inline tags
				echo wp_kses(
					nl2br($hours),
					[
						'br'     => [],
						'strong' => [],
						'b'      => [],
						'em'     => [],
						'i'      => [],
						'u'      => [],
						'p'      => [],
					]
				);
				?>
			</dd>
		<?php endif; ?>

		<!-- Detail Items -->
		<?php if (! empty($items)) : ?>
			<?php foreach ($items as $item) :
				if (! empty($item['heading']) || ! empty($item['description'])) : ?>
					<dt><?php echo wp_kses_post($item['heading']); ?></dt>
					<dd><?php echo wp_kses_post($item['description']); ?></dd>
			<?php endif;
			endforeach; ?>
		<?php endif; ?>

		<!-- Bullet List -->
		<?php if (! empty($bulletHeading)) : ?>
			<dt class="bullet-list-heading"><?php echo wp_kses_post($bulletHeading); ?></dt>
		<?php endif; ?>

		<?php if (! empty($bullets)) : ?>
			<ul class="bullet-list no-bt-border">
				<?php foreach ($bullets as $bullet) :
					$text = is_array($bullet) ? ($bullet['text'] ?? '') : $bullet;
					if (! empty($text)) : ?>
						<li class="bullet-list-item"><?php echo wp_kses_post($text); ?></li>
				<?php endif;
				endforeach; ?>
			</ul>
		<?php endif; ?>

		<!-- CTA -->
		<?php if (! empty($cta['text']) && ! empty($cta['url'])) : ?>
			<dd class="no-bt-border">
				<a class="overview-cta-button" href="<?php echo esc_url($cta['url']); ?>">
					<?php echo esc_html($cta['text']); ?>
				</a>
			</dd>
		<?php endif; ?>

	</dl>

	<!-- JSON-LD Schema -->
	<!-- <?php if (! empty($schema)) : ?>
		<script type="application/ld+json">
			<?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
		</script>
	<?php endif; ?> -->

</section>