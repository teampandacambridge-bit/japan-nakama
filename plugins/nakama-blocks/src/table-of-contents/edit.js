import { useSelect } from "@wordpress/data";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";

export default function Edit({ attributes, setAttributes }) {
	const { title } = attributes;

	// 1. Get post content
	const postContent = useSelect(
		(select) => select("core/editor").getEditedPostContent(),
		[]
	);

	// 2. Parse HTML
	const parser = new DOMParser();
	const doc = parser.parseFromString(postContent, "text/html");

	// 3. Extract H2 headings
	const h2Elements = Array.from(doc.querySelectorAll("h2[id]"));

	// 4. Build nested structure (H2 > H3)
	const structured = [];

	h2Elements.forEach((h2) => {
		const parent = {
			id: h2.getAttribute("id"),
			text: h2.textContent,
			level: 2,
			children: []
		};

		let el = h2.nextElementSibling;

		// Collect all H3s until next H2
		while (el && el.tagName !== "H2") {
			if (el.tagName === "H3" && el.hasAttribute("id")) {
				parent.children.push({
					id: el.getAttribute("id"),
					text: el.textContent,
					level: 3
				});
			}
			el = el.nextElementSibling;
		}

		structured.push(parent);
	});

	// 5. Save to block attributes
	useEffect(() => {
		setAttributes({ headings: structured });
	}, [postContent]);

	const blockProps = useBlockProps({ className: "toc-block" });

	return (
		<div {...blockProps}>
			<RichText
				tagName="h3"
				value={title}
				onChange={(value) => setAttributes({ title: value })}
				placeholder="Table of Contents"
			/>

			{structured.length === 0 ? (
				<p>No headings found.</p>
			) : (
				<ul>
					{structured.map((h2) => (
						<li key={h2.id}>
							<a href={`#${h2.id}`}>{h2.text}</a>

							{h2.children.length > 0 && (
								<ul>
									{h2.children.map((h3) => (
										<li key={h3.id}>
											<a href={`#${h3.id}`}>{h3.text}</a>
										</li>
									))}
								</ul>
							)}
						</li>
					))}
				</ul>
			)}
		</div>
	);
}
