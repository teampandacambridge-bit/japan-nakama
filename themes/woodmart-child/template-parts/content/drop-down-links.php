<?php
$categories = get_categories([
    'taxonomy'   => 'category', // Default taxonomy for posts
    'hide_empty' => false,      // Include categories without posts
    'number'     => 2,
]); ?>

<?php if (!empty($categories)): ?>
    <div class="drop-down-links">
        <button id="open-links" class="merriweather-light">View All</button>
        <div id="links" class="links">
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li> <a href=""> <?php print_r($category->name); ?></a> </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>