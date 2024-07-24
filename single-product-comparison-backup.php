<?php
/*
Template Name: Product Comparison
*/

get_header();
wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), filemtime(get_stylesheet_directory() . '/product-comparison.css'));
?>

<div class="lp lp_editable_sections sr-green-powders variant-278004">
    <div class="section-1">
        <p class="disclosure-top"><?php echo get_custom_field('disclosure_top'); ?></p>
        <h1><?php the_title(); ?></h1>
        <h2><?php echo get_custom_field('subtitle'); ?></h2>
        
        <div class="nav-bar">
            <a href="#benefits"><?php echo get_custom_field('benefits_nav_text'); ?></a>
            <a href="#ingredients" class="menu-toggled"><?php echo get_custom_field('ingredients_nav_text'); ?></a>
            <a href="#top_5"><?php echo get_custom_field('top_5_nav_text'); ?></a>
        </div>
        
        <p class="disclosure"><?php echo get_custom_field('disclosure'); ?></p>
        
        <?php the_content(); ?>
        
        <a name="benefits"></a>
        <h3><?php echo get_custom_field('benefits_title'); ?></h3>
        <div class="colored-table green">
            <h3><?php echo get_custom_field('benefits_subtitle'); ?></h3>
            <div class="table-body">
                <?php echo get_custom_field('benefits_content'); ?>
            </div>
        </div>
        
        <h3><?php echo get_custom_field('usage_title'); ?></h3>
        <?php echo get_custom_field('usage_content'); ?>
        
        <a name="ingredients"></a>
        <div class="colored-table green">
            <h3><?php echo get_custom_field('ingredients_to_look_for_title'); ?></h3>
            <div class="table-body">
                <?php echo get_custom_field('ingredients_to_look_for_content'); ?>
            </div>
        </div>
        
        <div class="colored-table red">
            <h3><?php echo get_custom_field('ingredients_to_avoid_title'); ?></h3>
            <div class="table-body">
                <?php echo get_custom_field('ingredients_to_avoid_content'); ?>
            </div>
        </div>
        
        <div class="colored-table blue">
            <h3><?php echo get_custom_field('considerations_title'); ?></h3>
            <div class="table-body">
                <?php echo get_custom_field('considerations_content'); ?>
            </div>
        </div>
        
        <h3 style="text-align: center;"><?php echo get_custom_field('top_products_title'); ?></h3>
    </div>
    
    <div class="section-2">
        <a name="top_5"></a>
        <?php
        $num_products = intval(get_custom_field('num_products', '5'));
        for ($i = 1; $i <= $num_products; $i++) {
            $product_name = get_custom_field("product_{$i}_name");
            $product_brand = get_custom_field("product_{$i}_brand");
            $product_link = get_custom_field("product_{$i}_link");
            $product_image = get_custom_field("product_{$i}_image");
            $product_rating = get_custom_field("product_{$i}_rating");
            $product_grade = get_custom_field("product_{$i}_grade");
            $product_pros = get_custom_field("product_{$i}_pros");
            $product_cons = get_custom_field("product_{$i}_cons");
            $product_bottom_line = get_custom_field("product_{$i}_bottom_line");
            ?>
            <div class="review">
                <h4><a href="<?php echo esc_url($product_link); ?>"><?php echo esc_html($i . '. ' . $product_name); ?></a></h4>
                <p class="byline">by <?php echo esc_html($product_brand); ?></p>
                
                <div class="product-image-box">
                    <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_name); ?>" />
                </div>
                
                <div class="circle-summary">
                    <div class="circle-text">
                        <h4>Total Ranking</h4>
                        <h5><?php echo esc_html($product_rating); ?>/10</h5>
                    </div>
                </div>
                
                <div class="grade">
                    <h1><?php echo esc_html($product_grade); ?></h1>
                    <p>Overall Grade</p>
                </div>
                
                <div class="pros-cons">
                    <h5>PROS</h5>
                    <?php echo wp_kses_post($product_pros); ?>
                    
                    <h5>CONS</h5>
                    <?php echo wp_kses_post($product_cons); ?>
                </div>
                
                <div class="bottom-line">
                    <h5>The Bottom Line</h5>
                    <?php echo wp_kses_post($product_bottom_line); ?>
                    
                    <p><small><?php echo get_custom_field('results_disclaimer'); ?></small></p>
                    
                    <button class="toggle">Show More</button>
                    <a class="normal" href="<?php echo esc_url($product_link); ?>">Learn More</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    
    <div class="section-additional">
        <div class="citations">
            <h3><?php echo get_custom_field('citations_title'); ?></h3>
            <?php echo wp_kses_post(get_custom_field('citations')); ?>
        </div>
    </div>
    
    <div class="section-last">
        <p><a href="#top_5"><?php echo get_custom_field('back_to_top_text'); ?></a></p>
    </div>
</div>

<?php get_footer(); ?>
