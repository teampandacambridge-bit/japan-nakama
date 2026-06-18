<?php
$heading   = $attributes['heading'] ?? '';
$cost      = $attributes['cost'] ?? '';
$address   = $attributes['address'] ?? '';
$startDate = $attributes['startDate'] ?? ['date' => '', 'time' => ''];
$endDate   = $attributes['endDate'] ?? ['date' => '', 'time' => ''];
$items     = $attributes['items'] ?? [];
$listHeading = $attributes['listHeading'] ?? '';
$list = $attributes['list'] ?? [];
$cta = $attributes['cta'] ?? ['text' => '', 'url' => ''];

?>

<section <?php echo get_block_wrapper_attributes(['class' => 'event-overview']); ?> itemscope itemtype="https://schema.org/Event">

	<?php if (! empty($heading)) : ?>
		<h2 itemprop="name"><?php echo esc_html($heading); ?></h2>
	<?php else : ?>
		<h2 itemprop="name"><?php esc_html_e('Overview', 'event-overview'); ?></h2>
	<?php endif; ?>

	<dl class="overview-meta">

		<?php if (! empty($address)) : ?>
			<dt><?php esc_html_e('Address', 'event-overview'); ?></dt>
			<dd itemprop="location"><?php echo wp_kses_post($address); ?></dd>
		<?php endif; ?>

		<?php if (! empty($cost)) : ?>
			<dt><?php esc_html_e('Admission', 'event-overview'); ?></dt>
			<dd itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				<span itemprop="price"><?php echo wp_kses_post($cost); ?></span>
			</dd>
		<?php endif; ?>

		<?php if (! empty($startDate['date']) || ! empty($startDate['time'])) : ?>
			<dt><?php esc_html_e('Starts', 'event-overview'); ?></dt>
			<dd>
				<?php if (! empty($startDate['date'])) : ?>
					<time itemprop="startDate" datetime="<?php echo esc_attr($startDate['date']); ?>">
						<?php echo esc_html(date('F j, Y', strtotime($startDate['date']))); ?>
					</time>
				<?php endif; ?>

				<?php if (! empty($startDate['time'])) : ?>
					<span class="event-time"> ,
						<?php echo esc_html(date('g:i A', strtotime($startDate['time']))); ?>
					</span>
				<?php endif; ?>
			</dd>
		<?php endif; ?>

		<?php if (! empty($endDate['date']) || ! empty($endDate['time'])) : ?>
			<dt><?php esc_html_e('Ends', 'event-overview'); ?></dt>
			<dd>
				<?php if (! empty($endDate['date'])) : ?>
					<time itemprop="endDate" datetime="<?php echo esc_attr($endDate['date']); ?>">
						<?php echo esc_html(date('F j, Y', strtotime($endDate['date']))); ?>
					</time>
				<?php endif; ?>

				<?php if (! empty($endDate['time'])) : ?>
					<span class="event-time">
						<?php echo esc_html(date('g:i A', strtotime($endDate['time']))); ?>
					</span>
				<?php endif; ?>
			</dd>
		<?php endif; ?>

		<?php if (! empty($items)) : ?>
			<?php foreach ($items as $item) : ?>
				<?php if (! empty($item['heading']) || ! empty($item['description'])) : ?>
					<dt><?php echo wp_kses_post($item['heading']); ?></dt>
					<dd><?php echo wp_kses_post($item['description']); ?></dd>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php print_r($list) ?>


		<!-- bullet list -->
		<?php if (! empty($list)) : ?>
			<?php if ($listHeading) : ?>
				<h3 class="bullet-list-heading"><?php echo wp_kses_post($listHeading); ?></h3>
			<?php endif; ?>
			<ul>
				<?php foreach ($list as $listItem) : ?>
					<li class="bullet-list-item"><?php echo wp_kses_post($listItem); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>



		<!-- CTA -->
		<?php if (! empty($cta['text']) && ! empty($cta['url'])) : ?>
			<dt><?php esc_html_e('Book Tickets', 'event-overview'); ?></dt>
			<dd class="no-bt-border">
				<a class="overview-cta-button" href="<?php echo esc_url($cta['url']); ?>">
					<?php echo esc_html($cta['text']); ?>
				</a>
			</dd>
		<?php endif; ?>


	</dl>



</section>