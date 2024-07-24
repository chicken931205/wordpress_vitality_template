<?php
/*
Template Name: Multiproduct
*/

get_header();

wp_enqueue_style('multiproduct-style', get_stylesheet_directory_uri() . '/multiproduct.css', array(), '1.1');
wp_enqueue_script('multiproduct-script', get_stylesheet_directory_uri() . '/multiproduct.js', array('jquery'), '1.1', true);

$post_id = get_the_ID();
?>

<div class="container">
    <div class="sticky-header">
        <nav>
            <a href="#benefits" class="active"><?php echo get_post_meta($post_id, 'benefits_nav_text', true); ?></a>
            <a href="#key-ingredients"><?php echo get_post_meta($post_id, 'ingredients_nav_text', true); ?></a>
            <a href="#top-5"><?php echo get_post_meta($post_id, 'top_5_nav_text', true); ?></a>
        </nav>
        <div class="progress-indicator">
            <div class="progress-circle">
                <span class="progress-percentage">0%</span>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="content-area">
            <p class="disclosure-top"><?php echo get_post_meta($post_id, 'disclosure_top', true); ?></p>
            <h1><?php the_title(); ?></h1>
            <h2><?php echo get_post_meta($post_id, 'subtitle', true); ?></h2>

            <div class="health-benefits">
                <!-- Add your health benefits icons here -->
                <div class="benefit-item">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cognitive-health-icon.png" alt="Cognitive Health">
                    <span>Cognitive Health</span>
                </div>
                <!-- Add more benefit items as needed -->
            </div>

            <p class="disclosure"><?php echo get_post_meta($post_id, 'disclosure', true); ?></p>

            <?php the_content(); ?>

            <section id="benefits" class="benefits">
                <h2><?php echo get_post_meta($post_id, 'benefits_title', true); ?></h2>
                <?php echo wpautop(get_post_meta($post_id, 'benefits_content', true)); ?>
            </section>

            <section id="key-ingredients" class="key-ingredients">
                <div class="what-to-look-for">
                    <h2><?php echo get_post_meta($post_id, 'ingredients_to_look_for_title', true); ?></h2>
                    <?php echo wpautop(get_post_meta($post_id, 'ingredients_to_look_for_content', true)); ?>
                </div>
                <div class="what-to-avoid">
                    <h2><?php echo get_post_meta($post_id, 'ingredients_to_avoid_title', true); ?></h2>
                    <?php echo wpautop(get_post_meta($post_id, 'ingredients_to_avoid_content', true)); ?>
                </div>
            </section>

            <section id="top-5" class="multiproduct">
                <h2><?php echo get_post_meta($post_id, 'top_products_title', true); ?></h2>
                <?php
                $num_products = intval(get_post_meta($post_id, 'num_products', true));
                for ($i = 1; $i <= $num_products; $i++) {
                    $product_name = get_post_meta($post_id, "product_{$i}_name", true);
                    $product_brand = get_post_meta($post_id, "product_{$i}_brand", true);
                    $product_link = get_post_meta($post_id, "product_{$i}_link", true);
                    $product_image = get_post_meta($post_id, "product_{$i}_image", true);
                    $product_rating = get_post_meta($post_id, "product_{$i}_rating", true);
                    $product_grade = get_post_meta($post_id, "product_{$i}_grade", true);
                    $product_pros = get_post_meta($post_id, "product_{$i}_pros", true);
                    $product_cons = get_post_meta($post_id, "product_{$i}_cons", true);
                    $product_bottom_line = get_post_meta($post_id, "product_{$i}_bottom_line", true);
                    ?>
                    <div class="product-card">
                        <h3><?php echo esc_html($i . '. ' . $product_name); ?></h3>
                        <p class="product-brand">by <?php echo esc_html($product_brand); ?></p>
                        
                        <div class="product-grade">
                            <span><?php echo esc_html($product_grade); ?></span>
                            <p>OVERALL GRADE</p>
                        </div>

                        <div class="product-image">
                            <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_name); ?>" />
                        </div>
                        
                        <div class="product-pros-cons">
                            <div class="pros">
                                <h4>PROS</h4>
                                <?php echo wpautop($product_pros); ?>
                            </div>
                            
                            <div class="cons">
                                <h4>CONS</h4>
                                <?php echo wpautop($product_cons); ?>
                            </div>
                        </div>
                        
                        <div class="product-bottom-line">
                            <h4>The Bottom Line</h4>
                            <?php echo wpautop($product_bottom_line); ?>
                        </div>

                        <div class="product-rating">
                            <span>Total Ranking</span>
                            <p><?php echo esc_html($product_rating); ?>/10</p>
                        </div>
                        
                        <a class="learn-more" href="<?php echo esc_url($product_link); ?>">Learn More</a>
                    </div>
                    <?php
                }
                ?>
            </section>

            <section class="citations">
                <h2><?php echo get_post_meta($post_id, 'citations_title', true); ?></h2>
                <?php echo wpautop(get_post_meta($post_id, 'citations', true)); ?>
            </section>
            
            <div class="back-to-top">
                <a href="#top-5"><?php echo get_post_meta($post_id, 'back_to_top_text', true); ?></a>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebar-content">
                <h3>What You Will Learn:</h3>
                <div class="estimated-read-time">
                    <div class="progress-ring">
                        <svg>
                            <circle cx="30" cy="30" r="28"></circle>
                            <circle cx="30" cy="30" r="28"></circle>
                        </svg>
                        <div class="progress-text">
                            <span class="percentage">0%</span>
                        </div>
                    </div>
                    <p>Estimated Read Time: 5 Minutes</p>
                </div>
                <ul class="sidebar-nav">
                    <li><a href="#benefits">Benefits of a Quality Green Powder</a></li>
                    <li><a href="#key-ingredients">What To Look For In A Green Powder</a></li>
                    <li><a href="#what-to-avoid">What Ingredients To Avoid</a></li>
                    <li><a href="#top-5">Top 5 Green Powders</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
