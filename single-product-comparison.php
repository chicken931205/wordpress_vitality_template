<?php
/*
Template Name: Product Comparison
*/

get_header();

wp_enqueue_style( 'google-fonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', false );
wp_enqueue_style( 'google-fonts-open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap', false );
wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), '1.1');
wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

$post_id = get_the_ID();
?>

<div class="main">
    <div class="lp">
        <div class="section-1">
            <p class="disclosure-top"><?php echo esc_html(get_post_meta($post_id, 'disclosure_top', true)); ?></p>
            <h1><?php the_title(); ?></h1>
            <h2><?php echo esc_html(get_post_meta($post_id, 'subtitle', true)); ?></h2>

            <div class="nav-bar">
                <a href="#benefits"><?php echo esc_html(get_post_meta($post_id, 'benefits_nav_text', true)); ?></a>
                <a href="#key-ingredients"><?php echo esc_html(get_post_meta($post_id, 'ingredients_nav_text', true)); ?></a>
                <a href="#top-5"><?php echo esc_html(get_post_meta($post_id, 'top_5_nav_text', true)); ?></a>
            </div>

            <p class="disclosure"><?php echo esc_html(get_post_meta($post_id, 'disclosure', true)); ?></p>

            <?php if (has_post_thumbnail()): ?>
                <p>
                    <?php the_post_thumbnail('full', array('class' => 'featured-image')); ?>
                </p>
            <?php endif; ?>
            
            <?php the_content(); ?>

            <?php 
            $effect_image = get_post_meta($post_id, 'effect_image', true);
            if ($effect_image): 
            ?>
                <h3>
                    <img src="<?php echo esc_url($effect_image); ?>" alt="The Effect">
                </h3>
            <?php endif; ?>

            <div id="benefits" class="colored-table green">
                <h3><?php echo esc_html(get_post_meta($post_id, 'benefits_title', true)); ?></h3>
                <?php echo wp_kses_post(wpautop(get_post_meta($post_id, 'benefits_content', true))); ?>
            </div>

            <div id="usage">
                <h3><?php echo esc_html(get_post_meta($post_id, 'usage_title', true)); ?></h3>
                <?php echo wp_kses_post(wpautop(get_post_meta($post_id, 'usage_content', true))); ?>
            </div>

            <div id="key-ingredients" class="colored-table green">
                <h3><?php echo esc_html(get_post_meta($post_id, 'ingredients_to_look_for_title', true)); ?></h3>
                <?php echo wp_kses_post(wpautop(get_post_meta($post_id, 'ingredients_to_look_for_content', true))); ?>
            </div>

            <div id="ingredients-to-avoid" class="colored-table red">
                <h3><?php echo esc_html(get_post_meta($post_id, 'ingredients_to_avoid_title', true)); ?></h3>
                <?php echo wp_kses_post(wpautop(get_post_meta($post_id, 'ingredients_to_avoid_content', true))); ?>
            </div>

            <div id="considerations" class="colored-table blue">
                <h3><?php echo esc_html(get_post_meta($post_id, 'considerations_title', true)); ?></h3>
                <?php echo wp_kses_post(wpautop(get_post_meta($post_id, 'considerations_content', true))); ?>
            </div>

            <h3 style="text-align: center;"><?php echo esc_html(get_post_meta($post_id, 'top_products_title', true)); ?></h3>
        </div>
        <div id="top-5" class="section-2">
            <?php
            $num_products = intval(get_post_meta($post_id, 'num_products', true));
            for ($i = 1; $i <= $num_products; $i++):
                $product_name = get_post_meta($post_id, "product_{$i}_name", true);
                $product_brand = get_post_meta($post_id, "product_{$i}_brand", true);
                $product_link = get_post_meta($post_id, "product_{$i}_link", true);
                $product_image = get_post_meta($post_id, "product_{$i}_image", true);
                $product_rating_image = get_post_meta($post_id, "product_{$i}_rating_image", true);
                $product_grade = get_post_meta($post_id, "product_{$i}_grade", true);
                $product_pros = get_post_meta($post_id, "product_{$i}_pros", true);
                $product_cons = get_post_meta($post_id, "product_{$i}_cons", true);
                $product_bottom_line = get_post_meta($post_id, "product_{$i}_bottom_line", true);
            ?>
            <div class="review test1">
                <h4>
                    <a href="<?php echo esc_url($product_link); ?>"><?php echo $i; ?>. <?php echo esc_html($product_name); ?></a>
                    <?php if ($i === 1): ?>
                        <sup><a href="#citations">[1]</a></sup>
                    <?php endif; ?>
                </h4>
                <p class="byline">by <a href="<?php echo esc_url($product_link); ?>"><?php echo esc_html($product_brand); ?></a></p>
                <?php if ($product_rating_image): ?>
                    <img src="<?php echo esc_url($product_rating_image); ?>" width="118" height="115" alt="rating" class="rating-image">
                <?php endif; ?>
                <div class="product-image-box">
                    <a href="<?php echo esc_url($product_link); ?>">
                        <?php if ($product_image): ?>
                            <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_name); ?>">
                        <?php endif; ?>
                    </a>
                </div>
                <div class="grade">
                    <h1><?php echo esc_html($product_grade); ?></h1>
                    <p>OVERALL GRADE</p>
                </div>
                <div class="left">
                    <div class="pros-cons">
                        <h3>PROS</h3>
                        <?php echo wp_kses_post($product_pros); ?>
                        <h3>CONS</h3>
                        <?php echo wp_kses_post($product_cons); ?>
                    </div>
                </div>
                <div class="right">
                    <h5>Bottom Line</h5>
                    <?php echo wp_kses_post(wpautop($product_bottom_line)); ?>
                    <a href="<?php echo esc_url($product_link); ?>">Visit Website</a>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <div class="section-additional">
            <div id="citations" class="citations">
                <h3><?php echo esc_html(get_post_meta($post_id, 'citations_title', true)); ?></h3>
                <?php echo wp_kses_post(wpautop(get_post_meta($post_id, 'citations', true))); ?>
            </div>
        </div>

        <div class="section-last">
            <p><a href="#top-5"><?php echo esc_html(get_post_meta($post_id, 'back_to_top_text', true)); ?></a></p>
        </div>

        <div class="section-additional">
            <div class="right-sidebar">
                <div class="right-panel main-sources">
                    <h2><?php echo esc_html(get_post_meta($post_id, 'sidebar_1_title', true)); ?></h2>
                    <?php
                    $image_1 = get_post_meta($post_id, 'sidebar_1_image_1', true);
                    $image_2 = get_post_meta($post_id, 'sidebar_1_image_2', true);
                    if ($image_1): ?>
                        <p><img src="<?php echo esc_url($image_1); ?>" alt="Source 1"></p>
                    <?php endif;
                    if ($image_2): ?>
                        <p><img src="<?php echo esc_url($image_2); ?>" alt="Source 2"></p>
                    <?php endif; ?>
                    <p><?php echo esc_html(get_post_meta($post_id, 'sidebar_1_subtitle', true)); ?></p>
                </div>
                <div class="right-panel what-you-learn">
                    <h2><?php echo esc_html(get_post_meta($post_id, 'sidebar_2_title', true)); ?></h2>
                    <div class="reading-time">
                        <div class="reading-progress">
                            <div class="percent">0%</div>
                            <svg class="progress-circle" width="100%" height="100%">
                                <circle cx="40" cy="40" r="34"></circle>
                                <circle cx="40" cy="40" r="34"></circle>
                            </svg>
                        </div>
                        <p><?php echo esc_html(get_post_meta($post_id, 'sidebar_2_subtitle', true)); ?> <span id="read-time">5</span> Minutes</p>
                    </div>
                    <hr>
                    <?php
                    $sidebar_links = array(
                        array('title' => 'benefits_title', 'link' => '#benefits', 'icon' => 'sidebar_2_icon_1'),
                        array('title' => 'usage_title', 'link' => '#usage', 'icon' => 'sidebar_2_icon_2'),
                        array('title' => 'ingredients_to_look_for_title', 'link' => '#key-ingredients', 'icon' => 'sidebar_2_icon_3'),
                        array('title' => 'ingredients_to_avoid_title', 'link' => '#ingredients-to-avoid', 'icon' => 'sidebar_2_icon_4'),
                        array('title' => 'considerations_title', 'link' => '#considerations', 'icon' => 'sidebar_2_icon_5'),
                        array('title' => 'top_products_title', 'link' => '#top-5', 'icon' => 'sidebar_2_icon_6')
                    );

                    foreach ($sidebar_links as $link_data):
                        $title = get_post_meta($post_id, $link_data['title'], true);
                        $icon = get_post_meta($post_id, $link_data['icon'], true);
                        $icon_class = ($icon === 'active') ? 'icon-ok' : 'icon-cancel';
                        if ($title):
                    ?>
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        <p><a href="<?php echo esc_attr($link_data['link']); ?>"><?php echo esc_html($title); ?></a></p>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
