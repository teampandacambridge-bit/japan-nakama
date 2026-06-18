<?php
$heading = ! empty($attributes['heading']) ? esc_html($attributes['heading']) : '';
$map     = ! empty($attributes['map']) ? esc_url($attributes['map']) : '';
$addressEnglish  = ! empty($attributes['addressEnglish']) ? esc_html($attributes['addressEnglish']) : '';
$addressJapanese = ! empty($attributes['addressJapanese']) ? esc_html($attributes['addressJapanese']) : '';
?>
<section <?php echo get_block_wrapper_attributes(); ?>>
	<?php if ($heading) : ?>
		<h2><?php echo $heading; ?></h2>
	<?php endif; ?>

	<?php if ($map) : ?>
		<div class="map">
			<iframe src="<?php echo $map; ?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	<?php endif; ?>

	<?php if ($addressEnglish) : ?>
		<address>
			<span>English : </span><?php echo $addressEnglish; ?>
		</address>
	<?php endif; ?>

	<?php if ($addressJapanese) : ?>
		<address>
			<span>Japanese : </span><?php echo $addressJapanese; ?>
		</address>
	<?php endif; ?>

</section>