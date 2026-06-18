<?php

$heading        = $attributes['heading'] ?? '';
$cost           = $attributes['cost'] ?? '';
$address        = $attributes['address'] ?? '';
$hours          = $attributes['hours'] ?? '';
$items          = $attributes['items'] ?? [];
$bullets        = $attributes['bullets'] ?? [];
$bulletHeading  = $attributes['bulletHeading'] ?? '';
$cta            = $attributes['cta'] ?? ['text' => '', 'url' => ''];

$description    = $attributes['description'] ?? '';
$datePublished  = $attributes['datePublished'] ?? '';
$url            = $attributes['url'] ?? get_permalink();
$images         = $attributes['images'] ?? [];

if (! is_array($items)) {
	$items = [];
}
if (! is_array($bullets)) {
	$bullets = [];
}
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
				<a class="overview-cta-button"
					href="<?php echo esc_url($cta['url']); ?>"
					target="_blank"
					rel="noopener noreferrer">
					<?php echo esc_html($cta['text']); ?>
				</a>

			</dd>
		<?php endif; ?>

	</dl>
</section>

<?php
// ------------------------------------------------------------
// JSON-LD Schema: TouristAttraction
// ------------------------------------------------------------

$schema = [
	"@context"        => "https://schema.org",
	"@type"           => "TouristAttraction",
	"name"            => $heading,
	"description"     => $description,
	"url"             => $url,
	"datePublished"   => $datePublished,
	"publisher"       => [
		"@type" => "Organization",
		"name"  => get_bloginfo('name'),
		"url"   => home_url()
	],
	"offers" => [
		"@type"         => "Offer",
		"price"         => $cost,
		"priceCurrency" => "USD"
	],
	"address" => [
		"@type"         => "PostalAddress",
		"streetAddress" => $address
	],
	"openingHours" => $hours,
	"containsPlace" => array_map(function ($item) {
		return [
			"@type" => "Place",
			"name"  => $item['heading'] ?? $item
		];
	}, $items),
	"touristType" => $bullets,
	"additionalProperty" => [
		"@type" => "PropertyValue",
		"name"  => $bulletHeading,
		"value" => implode(', ', array_map(function ($b) {
			return is_array($b) ? ($b['text'] ?? '') : $b;
		}, $bullets))
	],
	"potentialAction" => [
		"@type"  => "Action",
		"name"   => $cta['text'],
		"target" => $cta['url']
	]
];

printf(
	'<script type="application/ld+json">%s</script>',
	wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
?>