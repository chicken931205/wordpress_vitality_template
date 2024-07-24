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
            <p class="disclosure-top"><?php echo get_post_meta($post_id, 'disclosure_top', true); ?></p>
            <h1>We Evaluate: <?php the_title(); ?></h1>
            <h2><?php echo get_post_meta($post_id, 'subtitle', true); ?></h2>

            <div class="nav-bar">
                <a href="#benefits"><?php echo get_post_meta($post_id, 'benefits_nav_text', true); ?></a>
                <a href="#key-ingredients"><?php echo get_post_meta($post_id, 'ingredients_nav_text', true); ?></a>
                <a href="#top-5"><?php echo get_post_meta($post_id, 'top_5_nav_text', true); ?></a>
            </div>

            <p class="disclosure"><?php echo get_post_meta($post_id, 'disclosure', true); ?></p>

            <p>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cognitive-health-icon.png" alt="Cognitive Health">
            </p>
            
            <p>
                <?php the_content(); ?>
            </p>

            <h3>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/The-Effect-of-bigger.png">
            </h3>

            <div id="benefits" class="colored-table green">
                <h3><?php echo get_post_meta($post_id, 'benefits_title', true); ?></h3>
                <?php echo get_post_meta($post_id, 'benefits_content', true); ?>
            </div>

            <h3>How To Use A Green Powder</h3>
            <p>Green powders are the best way to cover all your nutritional bases in one simple scoop.&nbsp;Many people enjoy mixing it with their&nbsp;<b>morning glass of&nbsp;water, tea,&nbsp;or&nbsp;smoothie.</b></p>
            <p>The combination of superfoods and gut-boosting probiotics can elevate your health and meet your food diversity goal. This simple&nbsp;<b>morning ritual helps customers stay consistent</b>&nbsp;with their green powder intake,&nbsp;<b>producing the&nbsp;best results.</b></p>

            <div id="key-ingredients" class="colored-table green">
                <h3><?php echo get_post_meta($post_id, 'ingredients_to_look_for_title', true); ?></h3>
                <?php echo get_post_meta($post_id, 'ingredients_to_look_for_content', true); ?>
            </div>

            <div id="what-to-avoid" class="colored-table red">
                <h3><?php echo get_post_meta($post_id, 'ingredients_to_avoid_title', true); ?></h3>
                <?php echo get_post_meta($post_id, 'ingredients_to_avoid_content', true); ?>
            </div>

            <div class="colored-table blue">
                <h3><?php echo get_post_meta($post_id, 'considerations_title', true); ?></h3>
                <?php echo get_post_meta($post_id, 'considerations_content', true); ?>
            </div>

            <h3 style="text-align: center;"><?php echo get_post_meta($post_id, 'top_products_title', true); ?></h3>
        </div>
        <div id="top-5" class="section-2">
            <?php
                $num_products = intval(get_post_meta($post_id, 'num_products', true));
                for ($i = 1; $i <= $num_products; $i++) {
                    $product_name = get_post_meta($post_id, "product_{$i}_name", true);
                    $product_brand = get_post_meta($post_id, "product_{$i}_brand", true);
                    $product_link = get_post_meta($post_id, "product_{$i}_link", true);
                    $product_rating_image = get_post_meta($post_id, "product_{$i}_rating_image", true);
                    $product_image = get_post_meta($post_id, "product_{$i}_image", true);
                    $product_image_width = get_post_meta($post_id, "product_{$i}_image_width", true);
                    $product_rating = get_post_meta($post_id, "product_{$i}_rating", true);
                    $product_grade = get_post_meta($post_id, "product_{$i}_grade", true);
                    $product_pros = get_post_meta($post_id, "product_{$i}_pros", true);
                    $product_cons = get_post_meta($post_id, "product_{$i}_cons", true);
                    $product_bottom_line = get_post_meta($post_id, "product_{$i}_bottom_line", true);
                    ?>
            <div class="review test1">
                <div>&nbsp;</div>
                <h4>
                    <a href="#"><?php echo $i; ?>. <span style="color: #0000ff;"><?php echo $product_name; ?> &nbsp;</span>
                    </a>
                    <?php if ($i === 1) { ?>
                        <sup style="top: 0;">
                            <a href="#">[1]</a>
                        </sup>
                    <?php } ?>
                </h4>
                <p class="byline">by 
                    <span style="color: #800080;">
                        <a href="#" style="text-decoration: underline;">
                            <span style="color: #0000ff;"><?php echo $product_brand;?></span>
                        </a>
                    </span> 
                </p>
                <img src="<?php echo $product_rating_image; ?>" width="118" height="115" alt="hat">
                <div class="product-image-box">
                    <a href="<?php echo $product_link; ?>" style="transition: all 0s ease 0s;">
                        <img width="<?php echo $product_image_width; ?>" src="<?php echo $product_image; ?>">
                    </a>
                </div>
                <div class="grade">
                    <?php echo $product_grade; ?>
                </div>
                <div class="left">
                    <div class="pros-cons">
                        <h3>PROS</h3>
                        <?php echo $product_pros; ?>
                        <h3>CONS</h3>
                        <?php echo $product_cons; ?>
                    </div>
                </div>
                <div class="right">
                    <?php echo $product_bottom_line; ?>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="section-additional">
            <div class="citations">
                <h3><?php echo get_post_meta($post_id, 'citations_title', true); ?></h3>
                <?php echo wpautop(get_post_meta($post_id, 'citations', true)); ?>
            </div>
        </div>

        <div class="section-last">
            <p><a href="#top-5" style="text-decoration: underline;"> <?php echo get_post_meta($post_id, 'back_to_top_text', true); ?> </a></p>
        </div>

        <div class="section-additional">
            <div class="right-sidebar">
                <div class="right-panel main-sources">
                    <h2>Our Main Sources</h2>
                    <p>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/images/medline-plus-logo.png'; ?>">
                    </p>
                    <p>
                        <img src="<?php echo get_stylesheet_directory_uri() . '/images/healthline-logo.png'; ?>">
                    </p>
                    <p>
                        Sources used for research purposes. Smarter-Reviews.com are not officially affiliated with these sites.
                    </p>
                </div>
                <div class="right-panel what-you-learn">
                    <h2>What You Will Learn:</h2>
                    <div class="reading-time">
                        <div class="reading-progress">
                            <div class="percent"> 7% </div>
                            <svg class="progress-circle" width="100%" height="100%">
                                <circle cx="40" cy="40" r="34"></circle>
                                <circle cx="40" cy="40" r="34"></circle>
                            </svg>
                        </div>
                        <p>Estimated Read Time <span id="read-time">5</span> Minutes</p>
                    </div>
                    <hr>
                    <i class="icon-ok"></i>
                    <p>
                        <a href="#benefits">Benefits of a Quality Green Powder</a>
                    </p>
                    <i class="icon-ok"></i>
                    <p>
                        <a href="#key-ingredients">What To Look For In A Green Powder</a>
                    </p>
                    <i class="icon-cancel"></i>
                    <p>
                        <a href="#what-to-avoid">What Ingredients To Avoid</a>
                    </p>
                    <i class="icon-ok"></i>
                    <p>
                        <a href="#top-5">Top 5 Green Powders</a>
                    </p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php get_footer(); ?>
