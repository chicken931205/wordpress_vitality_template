<?php
/*
Template Name: Product Review
*/

get_header();

wp_enqueue_style('product-review-style', get_stylesheet_directory_uri() . '/product-review.css', array(), '1.1');

while (have_posts()) :
    the_post();

    $num_products = get_post_meta(get_the_ID(), '_num_products', true) ?: 5;
    $intro = get_post_meta(get_the_ID(), '_intro_paragraph', true);
    $conclusion = get_post_meta(get_the_ID(), '_conclusion', true);
    $cta_text = get_post_meta(get_the_ID(), '_cta_text', true);
    $cta_link = get_post_meta(get_the_ID(), '_cta_link', true);
    $sidebar_ad_image = get_post_meta(get_the_ID(), '_sidebar_ad_image', true);
    ?>
    <div class="site">
        <div class="site-inner">
            <div class="content-area">
                <main class="site-main">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('product-review-article'); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header>

                        <div class="author-name-wrapper">
                            <div class="author">
                                <img class="author-image" src="https://gentlemantoday.co/wp-content/uploads/2023/12/eilamavi_good-looking_40-year-old_American_man_standing_in_a_wh_46a36e13-4680-4594-8ef0-d9fb7e16f956_612x612.jpg" alt="Roger Sinclaire" title="Roger Sinclaire">
                                <span class="author-name">Roger Sinclaire</span>
                            </div>
                        </div>
                        
                        <div class="entry-content">
                            <p class="has-medium-font-size" style="line-height:1.4">I tried out the top 5 men’s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…</p>
                            
                            <?php if (has_post_thumbnail()): ?>
                                <div class="wp-block-image">
                                    <figure class="aligncenter size-large">
                                        <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
                                    </figure>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-meta">
                                <span>
                                    <?php echo get_the_date('F j, Y'); ?>
                                </span>
                            </div>

                            <p>
                                <?php echo wp_kses_post($intro); ?>
                            </p>

                            
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

                                <h2 style="font-size: 28px;">
                                    <strong><strong><strong><strong><?php echo $i . ". "; ?><?php echo esc_html($name); ?></strong></strong></strong></strong>
                                </h2>

                                <div class="wp-block-image">
                                    <figure class="aligncenter size-large">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" width="1024" height="1024">
                                    </figure>
                                </div>

                                <p class="has-background" style="background-color: #e6e6e640">
                                    <strong>Effectiveness</strong>:
                                    <mark class="has-inline-color has-bright-blue-color"><?php echo esc_html($effectiveness); ?></mark>
                                    <br>
                                    <strong>Safety</strong>:
                                    <mark class="has-inline-color has-bright-blue-color"><?php echo esc_html($safety); ?></mark>
                                    <br>
                                    <strong>Price</strong>:
                                    <mark class="has-inline-color has-bright-blue-color"><?php echo esc_html($price); ?></mark>
                                    <br>
                                    <strong><strong><strong>Overall Rating</strong></strong></strong>
                                    <mark class="has-inline-color has-bright-blue-color"><?php echo esc_html($rating); ?></mark>
                                </p>

                                <p>
                                    <?php echo wp_kses_post($description); ?>
                                </p>
                                <?php if ($i === 1) { ?>
                                    <div class="wp-block-media-text alignwide is-vertically-aligned-center has-background" style="background-color:#e6e6e640;grid-template-columns:15% auto">
                                        <figure class="wp-block-media-text__media">
                                            <img decoding="async" width="150" height="150" src="https://gentlemantoday.co/wp-content/uploads/2023/07/Winner.png" alt="" class="wp-image-241 size-full">
                                        </figure>
                                        <div class="wp-block-media-text__content"><style></style>
                                            <p class="gb-66a13a12b2fea has-text-align-left has-medium-font-size">
                                                <mark style="background-color:rgba(0, 0, 0, 0);color:#0041e5" class="has-inline-color">
                                                    <strong><a href="">Particle Face Cream</a></strong>
                                                </mark> is my winning choice for the overall best facial product for men.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="wp-block-buttons is-content-justification-center is-layout-flex wp-container-core-buttons-layout-1 wp-block-buttons-is-layout-flex">
                                        <div class="wp-block-button has-custom-width wp-block-button__width-75 has-custom-font-size aligncenter is-style-fill has-medium-font-size">
                                            <a class="wp-block-button__link has-bright-blue-background-color has-background wp-element-button" href="" style="border-radius:20px" target="_blank" rel="noreferrer noopener">Learn More</a>
                                        </div>    
                                    </div>
                                    

                                    <p class="has-text-align-center">
                                        <strong>Get 20% Off Your Purchase!</strong>
                                        <br>
                                        <strong>With Special Promo Code 
                                            <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-vivid-red-color">FACEGT</mark>
                                        </strong>
                                        <br>
                                        <strong>Exclusive for Gentleman Today Readers!</strong>
                                    </p>
                                <?php } ?>
                                
                                
                            <?php endfor; ?>
                            

                            <div class="conclusion">
                                <h2>Conclusion</h2>
                                <?php echo wp_kses_post($conclusion); ?>
                            </div>

                            <div class="cta-section">
                                <a href="<?php echo esc_url($cta_link); ?>" class="cta-button"><?php echo esc_html($cta_text); ?></a>
                            </div>
                        </div>
                    </article>
                </main>

                <?php if ($sidebar_ad_image): ?>
                    <aside class="sidebar widget-area">
                        <a>
                            <img src="<?php echo esc_url($sidebar_ad_image); ?>" alt="Sidebar Ad" class="sidebar-ad-image">
                        </a>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>

    

    

<?php
endwhile;

get_footer();
?>
