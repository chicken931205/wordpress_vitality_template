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
                        
                        <div class="entry-content">
                            
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
