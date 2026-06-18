<?php

$heading    = $attributes['heading'] ?? '';
$subHeading = $attributes['subHeading'] ?? '';
$faqData    = $attributes['items'] ?? [];

?>

<section class="faq">

    <?php if (!empty($heading)) : ?>
        <h2 class="faq__title ">
            <?= esc_html($heading); ?>
        </h2>
    <?php endif; ?>

    <?php if (!empty($subHeading)) : ?>
        <p class="faq__subtitle">
            <?= esc_html($subHeading); ?>
        </p>
    <?php endif; ?>

    <div class="faq__list">

        <?php foreach ($faqData as $i => $item): ?>
            <div class="faq__item">

                <button
                    class="faq__trigger"
                    aria-expanded="false"
                    aria-controls="faq-answer-<?= $i ?>">
                    <span><?= htmlspecialchars($item['question']); ?></span>
                    <svg class="faq__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div
                    class="faq__content"
                    id="faq-answer-<?= $i ?>"
                    role="region"
                    hidden>
                    <p><?= htmlspecialchars($item['answer']); ?></p>
                </div>

            </div>
        <?php endforeach; ?>

    </div>
</section>

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
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>