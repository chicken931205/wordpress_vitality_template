<?php
/*
Template Name: Product Review
*/

get_header();

while (have_posts()) :
    the_post();

    $num_products = get_post_meta(get_the_ID(), '_num_products', true) ?: 5;
    $intro = get_post_meta(get_the_ID(), '_intro_paragraph', true);
    $conclusion = get_post_meta(get_the_ID(), '_conclusion', true);
    $cta_text = get_post_meta(get_the_ID(), '_cta_text', true);
    $cta_link = get_post_meta(get_the_ID(), '_cta_link', true);
    $sidebar_ad_image = get_post_meta(get_the_ID(), '_sidebar_ad_image', true);
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('product-review-article'); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>
        <?php if (has_post_thumbnail()): ?>
            <div class="featured-image">
                <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
            </div>
        <?php endif; ?>
        <div class="article-date">
            <?php echo get_the_date('F j, Y'); ?>
        </div>

        <div class="entry-content">
            <div class="intro-paragraph">
                <?php echo wp_kses_post($intro); ?>
            </div>

            <div class="product-reviews">
                <?php
                for ($i = 1; $i <= $num_products; $i++) :
                    $name = get_post_meta(get_the_ID(), "_product_{$i}_name", true);
                    $effectiveness = get_post_meta(get_the_ID(), "_product_{$i}_effectiveness", true);
                    $safety = get_post_meta(get_the_ID(), "_product_{$i}_safety", true);
                    $price = get_post_meta(get_the_ID(), "_product_{$i}_price", true);
                    $rating = get_post_meta(get_the_ID(), "_product_{$i}_rating", true);
                    $image = get_post_meta(get_the_ID(), "_product_{$i}_image", true);
                    $description = get_post_meta(get_the_ID(), "_product_{$i}_description", true);
                    ?>
                    <div class="product-review <?php echo $i === 1 ? 'best-product' : ''; ?>">
                        <h2><?php echo esc_html($name); ?></h2>
                        <div class="product-details">
                            <div class="product-image">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" style="max-width: 800px; height: auto;">
                            </div>
                            <div class="product-info">
                                <div class="ratings">
                                    <div class="rating-item">
                                        <span class="rating-label">Effectiveness:</span>
                                        <span class="rating-value"><?php echo esc_html($effectiveness); ?></span>
                                    </div>
                                    <div class="rating-item">
                                        <span class="rating-label">Safety:</span>
                                        <span class="rating-value"><?php echo esc_html($safety); ?></span>
                                    </div>
                                    <div class="rating-item">
                                        <span class="rating-label">Price:</span>
                                        <span class="rating-value"><?php echo esc_html($price); ?></span>
                                    </div>
                                </div>
                                <div class="overall-rating">
                                    <span class="rating-label">Overall Rating:</span>
                                    <span class="rating-value"><?php echo esc_html($rating); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="product-description">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="conclusion">
                <h2>Conclusion</h2>
                <?php echo wp_kses_post($conclusion); ?>
            </div>

            <div class="cta-section">
                <a href="<?php echo esc_url($cta_link); ?>" class="cta-button"><?php echo esc_html($cta_text); ?></a>
            </div>
        </div>
    </article>

    <?php if ($sidebar_ad_image): ?>
        <div class="sidebar-ad">
            <img src="<?php echo esc_url($sidebar_ad_image); ?>" alt="Sidebar Ad" class="sidebar-ad-image">
        </div>
    <?php endif; ?>

<?php
endwhile;

get_footer();
?>
