<?php

$title    = $attributes['title'] ?? 'Table of Contents';
$headings = $attributes['headings'] ?? [];

?>

<section class="toc-block">

	<?php if (!empty($title)) : ?>
		<h2><?php echo esc_html($title); ?></h2>
	<?php endif; ?>

	<?php if (empty($headings)) : ?>

		<p>No headings found.</p>

	<?php else : ?>
		<nav class="table-of-content">
			<ul>
				<?php foreach ($headings as $h2) : ?>
					<li>
						<a href="#<?php echo esc_attr($h2['id']); ?>">
							<?php echo esc_html($h2['text']); ?>
						</a>

						<?php if (!empty($h2['children'])) : ?>
							<ul>
								<?php foreach ($h2['children'] as $h3) : ?>
									<li>
										<a href="#<?php echo esc_attr($h3['id']); ?>">
											<?php echo esc_html($h3['text']); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php endif; ?>

</section>