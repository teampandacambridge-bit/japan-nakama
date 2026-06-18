<?php

$boxLeft  = $attributes['boxLeft'] ?? [];
$boxRight = $attributes['boxRight'] ?? [];

// Left card fields
$left_image = ! empty($boxLeft['image']) ? esc_url($boxLeft['image']) : '';
$left_heading = $boxLeft['heading'] ?? '';
$left_text = $boxLeft['text'] ?? '';
$left_cta_text = $boxLeft['cta']['text'] ?? '';
$left_cta_url  = $boxLeft['cta']['url'] ?? '';

// Right card fields
$right_image = ! empty($boxRight['image']) ? esc_url($boxRight['image']) : '';
$right_heading = $boxRight['heading'] ?? '';
$right_text = $boxRight['text'] ?? '';
$right_cta_text = $boxRight['cta']['text'] ?? '';
$right_cta_url  = $boxRight['cta']['url'] ?? '';

?>

<section class="solid-box-links">

	<!-- LEFT CARD -->
	<div class="box-link bg-green">
		<?php if ($left_image): ?>
			<div class="image">
				<img src="<?php echo $left_image; ?>" alt="">
			</div>
		<?php endif; ?>

		<div class="text">
			<?php if ($left_heading): ?>
				<h2><?php echo esc_html($left_heading); ?></h2>
			<?php endif; ?>

			<?php if ($left_text): ?>
				<p><?php echo esc_html($left_text); ?></p>
			<?php endif; ?>

			<?php if ($left_cta_text && $left_cta_url): ?>
				<a href="<?php echo esc_url($left_cta_url); ?>" class="btn-pill">
					<?php echo esc_html($left_cta_text); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>



	<!-- RIGHT CARD -->
	<div class="box-link bg-green">
		<?php if ($right_image): ?>
			<div class="image">
				<img src="<?php echo $right_image; ?>" alt="">
			</div>
		<?php endif; ?>

		<div class="text">
			<?php if ($right_heading): ?>
				<h2><?php echo esc_html($right_heading); ?></h2>
			<?php endif; ?>

			<?php if ($right_text): ?>
				<p><?php echo esc_html($right_text); ?></p>
			<?php endif; ?>

			<?php if ($right_cta_text && $right_cta_url): ?>
				<a href="<?php echo esc_url($right_cta_url); ?>" class="btn-pill">
					<?php echo esc_html($right_cta_text); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>

</section>