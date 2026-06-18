<?php

$heading    = $attributes['heading'] ?? '';
$subHeading = $attributes['subHeading'] ?? '';
$items      = $attributes['items'] ?? [];

?>

<section class="faq-block">

	<?php if (! empty($heading)) : ?>
		<h2 class="faq-heading">
			<?php echo esc_html($heading); ?>
		</h2>
	<?php endif; ?>

	<?php if (! empty($subHeading)) : ?>
		<p class="faq-subheading">
			<?php echo esc_html($subHeading); ?>
		</p>
	<?php endif; ?>

	<?php if (! empty($items) && is_array($items)) : ?>
		<div class="faq-items">
			<?php foreach ($items as $item) :

				$question = $item['question'] ?? '';
				$answer   = $item['answer'] ?? '';

				if (empty($question) && empty($answer)) {
					continue;
				}
			?>
				<div class="faq-item">
					<?php if (! empty($question)) : ?>
						<h3 class="faq-question">
							<?php echo esc_html($question); ?>
						</h3>
					<?php endif; ?>

					<?php if (! empty($answer)) : ?>
						<div class="faq-answer">
							<?php echo wp_kses_post($answer); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</section>