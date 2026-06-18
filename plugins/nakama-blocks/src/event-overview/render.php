<?php
$heading       = $attributes['heading'] ?? '';
$cost          = $attributes['cost'] ?? '';
$address       = $attributes['address'] ?? '';
$startDate     = $attributes['startDate'] ?? ['date' => '', 'time' => ''];
$endDate       = $attributes['endDate'] ?? ['date' => '', 'time' => ''];
$items         = $attributes['items'] ?? [];
$bullets       = $attributes['bullets'] ?? [];
$bulletHeading = $attributes['bulletHeading'] ?? '';
$cta           = $attributes['cta'] ?? ['text' => '', 'url' => ''];
$description   = $attributes['description'] ?? '';
$images        = $attributes['images'] ?? [];
$url           = $attributes['url'] ?? get_permalink();

// Ensure arrays
if (! is_array($items))   $items = [];
if (! is_array($bullets)) $bullets = [];

// ---- Output the markup ----
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'post-overview-render']); ?>>

	<?php if (! empty($heading)) : ?>
		<h2><?php echo esc_html($heading); ?></h2>
	<?php else : ?>
		<h2><?php esc_html_e('Overview', 'event-overview'); ?></h2>
	<?php endif; ?>

	<dl class="overview-meta">
		<?php if (! empty($address)) : ?>
			<dt><?php esc_html_e('Address', 'event-overview'); ?></dt>
			<dd><?php echo wp_kses_post($address); ?></dd>
		<?php endif; ?>

		<?php if (! empty($cost)) : ?>
			<dt><?php esc_html_e('Admission', 'event-overview'); ?></dt>
			<dd><?php echo wp_kses_post($cost); ?></dd>
		<?php endif; ?>

		<?php if (! empty($startDate['date']) || ! empty($startDate['time'])) : ?>
			<dt><?php esc_html_e('Starts', 'event-overview'); ?></dt>
			<dd>
				<?php
				if (! empty($startDate['date'])) {
					echo esc_html(date('F j, Y', strtotime($startDate['date'])));
				}
				if (! empty($startDate['time'])) {
					echo '<span class="event-time">, ' . esc_html(date('g:i A', strtotime($startDate['time']))) . '</span>';
				}
				?>
			</dd>
		<?php endif; ?>

		<?php if (! empty($endDate['date']) || ! empty($endDate['time'])) : ?>
			<dt><?php esc_html_e('Ends', 'event-overview'); ?></dt>
			<dd>
				<?php
				if (! empty($endDate['date'])) {
					echo esc_html(date('F j, Y', strtotime($endDate['date'])));
				}
				if (! empty($endDate['time'])) {
					echo '<span class="event-time"> ' . esc_html(date('g:i A', strtotime($endDate['time']))) . '</span>';
				}
				?>
			</dd>
		<?php endif; ?>

		<?php if (! empty($items)) : ?>
			<?php foreach ($items as $item) :
				if (! empty($item['heading']) || ! empty($item['description'])) : ?>
					<dt><?php echo wp_kses_post($item['heading']); ?></dt>
					<dd><?php echo wp_kses_post($item['description']); ?></dd>
			<?php endif;
			endforeach; ?>
		<?php endif; ?>

		<?php if ($bulletHeading) : ?>
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
// JSON-LD Schema: Event
// ------------------------------------------------------------

$schema = [
	"@context"      => "https://schema.org",
	"@type"         => "Event",
	"name"          => $heading,
	"description"   => $description,
	"url"           => $url,
	"startDate"     => ! empty($startDate['date']) ? date('c', strtotime(trim($startDate['date'] . ' ' . ($startDate['time'] ?? '')))) : null,
	"endDate"       => ! empty($endDate['date']) ? date('c', strtotime(trim($endDate['date'] . ' ' . ($endDate['time'] ?? '')))) : null,
	"eventStatus"   => "https://schema.org/EventScheduled",
	"eventAttendanceMode" => "https://schema.org/OfflineEventAttendanceMode",
	"location"      => [
		"@type"         => "Place",
		"name"          => $heading . ' Venue',
		"address"       => [
			"@type"         => "PostalAddress",
			"streetAddress" => wp_strip_all_tags($address)
		]
	],
	"offers" => [
		"@type"         => "Offer",
		"price"         => preg_replace('/[^0-9.]/', '', $cost),
		"priceCurrency" => "JPY",
		"url"           => $url,
		"availability"  => "https://schema.org/InStock",
		"validFrom"     => date('c')
	],
	"performer" => array_values(array_filter(array_map(function ($item) {
		return ! empty($item['heading']) ? [
			"@type" => "Person",
			"name"  => $item['heading']
		] : null;
	}, $items))),
	"organizer" => [
		"@type" => "Organization",
		"name"  => get_bloginfo('name'),
		"url"   => home_url()
	],
	"keywords" => implode(', ', array_map(function ($b) {
		return is_array($b) ? ($b['text'] ?? '') : $b;
	}, $bullets)),
	"image" => array_map('esc_url', $images),
	"potentialAction" => [
		"@type"  => "Action",
		"name"   => $cta['text'],
		"target" => $cta['url']
	]
];

// Remove nulls (optional but cleaner)
$schema = array_filter($schema, fn($v) => ! is_null($v) && $v !== '');

printf(
	'<script type="application/ld+json">%s</script>',
	wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);
?>