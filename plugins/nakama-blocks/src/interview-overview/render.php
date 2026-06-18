<?php
$heading       = $attributes['heading'] ?? '';
$description   = $attributes['description'] ?? '';
$interviewee   = $attributes['interviewee'] ?? '';
$jobTitle      = $attributes['jobTitle'] ?? '';
$organization  = $attributes['organization'] ?? '';
$interviewer   = $attributes['interviewer'] ?? '';
$datePublished = $attributes['datePublished'] ?? '';
$url           = $attributes['url'] ?? get_permalink();

// Build Schema.org Interview data
$schema = [
	"@context" => "https://schema.org",
	"@type"    => "Interview",
	"headline" => $heading,
	"description" => $description,
	"interviewee" => [
		"@type" => "Person",
		"name"  => $interviewee,
		"jobTitle" => $jobTitle,
		"worksFor" => [
			"@type" => "Organization",
			"name"  => $organization
		]
	],
	"interviewer" => [
		"@type" => "Person",
		"name"  => $interviewer
	],
	"publisher" => [
		"@type" => "Organization",
		"name"  => get_bloginfo('name'),
		"url"   => home_url()
	],
	"datePublished"    => $datePublished,
	"mainEntityOfPage" => $url
];

if (!empty($schema)) {
	printf(
		'<script type="application/ld+json">%s</script>',
		wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
	);
}
