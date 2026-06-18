<?php

$heading		= $attributes['heading'] ?? '';
$subHeading		= $attributes['subHeading'] ?? '';
$cta            = $attributes['cta'] ?? ['text' => '', 'url' => ''];
$imageUrl     	= ! empty($attributes['imageUrl']) ? esc_url($attributes['imageUrl']) : '';

?>

<section
	class="card-full-width" style="background-image: url('<?php echo esc_url($imageUrl); ?>')">
	<div class="overlay">
		<?php if (! empty($heading)) : ?>
			<h2><?php echo esc_html($heading); ?></h2>
		<?php endif; ?>

		<?php if (! empty($subHeading)) : ?>
			<p><?php echo esc_html($subHeading); ?></p>
		<?php endif; ?>

		<?php if (! empty($cta['text']) && ! empty($cta['url'])) : ?>
			<a class="btn-pill" href="<?php echo esc_url($cta['url']); ?>">
				<?php echo esc_html($cta['text']); ?>
			</a>
		<?php endif; ?>
	</div>


</section>