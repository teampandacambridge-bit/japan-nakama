<?php
$faqData = [
	['question' => 'What is the return policy for your products?', 'answer' => 'We offer a 30-day return policy on all unused items in their original packaging. Simply contact our support team to initiate a return and receive a prepaid shipping label.'],
	['question' => 'How long does shipping usually take?', 'answer' => 'Standard shipping typically takes 5–7 business days within the continental US. Expedited options are available at checkout for 2–3 business day delivery.'],
	['question' => 'Do you offer international shipping?', 'answer' => 'Yes, we ship to over 50 countries worldwide. International orders usually arrive within 10–15 business days depending on the destination and customs processing times.'],
	['question' => 'How can I track my order?', 'answer' => 'Once your order ships, you\'ll receive a confirmation email with a tracking number. You can use that number on our website or the carrier\'s site to monitor your delivery status in real time.'],
	['question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards (Visa, Mastercard, American Express), PayPal, Apple Pay, and Google Pay. All transactions are encrypted and processed securely.'],
	['question' => 'How do I contact customer support?', 'answer' => 'You can reach our support team via email at support@example.com or through the live chat widget on our website. Our hours are Monday–Friday, 9 AM–6 PM EST.'],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Frequently Asked Questions</title>
	<link rel="stylesheet" href="faq.css">
	<script type="application/ld+json">
		<?= json_encode([
			'@context' => 'https://schema.org',
			'@type' => 'FAQPage',
			'mainEntity' => array_map(fn($item) => [
				'@type' => 'Question',
				'name' => $item['question'],
				'acceptedAnswer' => [
					'@type' => 'Answer',
					'text' => $item['answer'],
				],
			], $faqData),
		], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
	</script>
</head>

<body>
	<main class="faq-page">
		<section class="faq">
			<h1 class="faq__title">Frequently Asked Questions</h1>
			<div class="faq__list">
				<?php foreach ($faqData as $i => $item): ?>
					<div class="faq__item">
						<button class="faq__trigger" aria-expanded="false" aria-controls="faq-answer-<?= $i ?>">
							<span><?= htmlspecialchars($item['question']) ?></span>
							<svg class="faq__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<polyline points="6 9 12 15 18 9" />
							</svg>
						</button>
						<div class="faq__content" id="faq-answer-<?= $i ?>" role="region" hidden>
							<p><?= htmlspecialchars($item['answer']) ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</main>
	<script src="faq.js"></script>
</body>

</html>