<?php
$heading        = $attributes['heading'] ?? '';
$manufacturer   = $attributes['manufacturer'] ?? '';
$price          = $attributes['price'] ?? '';
$rating         = $attributes['rating'] ?? '';
$items          = $attributes['items'] ?? [];
$bullets        = $attributes['bullets'] ?? [];
$bulletHeading  = $attributes['bulletHeading'] ?? '';
$cons           = $attributes['cons'] ?? [];
$consHeading    = $attributes['consHeading'] ?? '';
$cta            = $attributes['cta'] ?? ['text' => '', 'url' => ''];


?>

<section <?php echo get_block_wrapper_attributes(['class' => 'post-overview-render']); ?>>

	<?php if (! empty($heading)) : ?>
		<h2><?php echo esc_html($heading); ?></h2>
	<?php endif; ?>

	<dl class="product-meta">
		<?php if ($manufacturer) : ?>
			<dt><?php esc_html_e('Brand:', 'product-review'); ?></dt>
			<dd><?php echo esc_html($manufacturer); ?></dd>
		<?php endif; ?>

		<?php if ($price) : ?>
			<dt><?php esc_html_e('Price:', 'product-review'); ?></dt>
			<dd><?php echo esc_html($price); ?></dd>
		<?php endif; ?>

		<?php if ($rating) : ?>
			<dt><?php esc_html_e('Rating:', 'product-review'); ?></dt>
			<dd><?php echo esc_html($rating); ?> / 5</dd>
		<?php endif; ?>
	</dl>

	<?php if (! empty($items)) : ?>
		<h3><?php esc_html_e('Key Features', 'product-review'); ?></h3>
		<dl class="product-features">
			<?php foreach ($items as $item) :
				if (! empty($item['heading']) || ! empty($item['description'])) : ?>
					<dt><?php echo wp_kses_post($item['heading']); ?></dt>
					<dd><?php echo wp_kses_post($item['description']); ?></dd>
			<?php endif;
			endforeach; ?>
		</dl>
	<?php endif; ?>

	<?php if ($bulletHeading || ! empty($bullets)) : ?>
		<h3 class="pd-bt-0"><?php echo esc_html($bulletHeading ?: __('Pros', 'product-review')); ?></h3>
		<ul class="product-pros">
			<?php foreach ($bullets as $bullet) :
				$text = is_array($bullet) ? ($bullet['text'] ?? '') : $bullet;
				if ($text) : ?>
					<li class="bullet-list-item"><?php echo wp_kses_post($text); ?></li>
			<?php endif;
			endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ($consHeading || ! empty($cons)) : ?>
		<h3 class="pd-bt-0"><?php echo esc_html($consHeading ?: __('Cons', 'product-review')); ?></h3>
		<ul class="product-cons">
			<?php foreach ($cons as $bullet) :
				$text = is_array($bullet) ? ($bullet['text'] ?? '') : $bullet;
				if ($text) : ?>
					<li class="bullet-list-item"><?php echo wp_kses_post($text); ?></li>
			<?php endif;
			endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if (! empty($cta['text']) && ! empty($cta['url'])) : ?>
		<!-- <dt class=" cta-heading"><?php esc_html_e('Link To Buy', 'event-overview'); ?></dt> -->
		<dd class="no-bt-border">
			<a class="overview-cta-button" href="<?php echo esc_url($cta['url']); ?>">
				<?php echo esc_html($cta['text']); ?>
			</a>
		</dd>
	<?php endif; ?>




</section>