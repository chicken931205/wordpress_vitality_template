<?php
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

// Enable WordPress debug logging
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}
if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}

function log_message($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, WP_CONTENT_DIR . '/debug.log');
}

log_message("Functions.php is being loaded");

// Enqueue parent and child styles
function child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles');

// Register product review template
function register_product_review_template($templates) {
    $templates['page-product-review.php'] = 'Product Review';
    log_message("Product review template registered. Templates: " . print_r($templates, true));
    return $templates;
}
add_filter('theme_post_templates', 'register_product_review_template');
add_filter('single_template', 'load_product_review_template');

function load_product_review_template($template) {
    global $post;
    $template_slug = get_page_template_slug($post->ID);
    log_message("load_product_review_template called. Template slug: $template_slug");
    if ('page-product-review.php' === $template_slug) {
        if ($theme_file = locate_template(array('page-product-review.php'))) {
            $template = $theme_file;
            log_message("Product review template loaded: $template");
        }
    }
    return $template;
}

// Add meta box for product review
function add_product_review_meta_box() {
    log_message("Attempting to add product review meta box");
    add_meta_box(
        'product_review_meta_box',
        'Product Review Details',
        'product_review_meta_box_callback',
        'post',
        'normal',
        'high'
    );
    log_message("Product review meta box added");
}
add_action('add_meta_boxes', 'add_product_review_meta_box');
/*
// Callback function for the meta box
function product_review_meta_box_callback($post) {
    log_message("Product review meta box callback started for post ID: " . $post->ID);
    wp_nonce_field('product_review_meta_box', 'product_review_meta_box_nonce');
    log_message("Nonce field added");

    $num_products = get_post_meta($post->ID, '_num_products', true) ?: 5;
    $intro = get_post_meta($post->ID, '_intro_paragraph', true);
    $conclusion = get_post_meta($post->ID, '_conclusion', true);
    $cta_text = get_post_meta($post->ID, '_cta_text', true);
    $cta_link = get_post_meta($post->ID, '_cta_link', true);

    echo '<p><label for="intro_paragraph">Intro Paragraph:</label><br>';
    wp_editor($intro, 'intro_paragraph', array('textarea_name' => 'intro_paragraph', 'textarea_rows' => 5));

    echo '<p><label for="num_products">Number of Products:</label> ';
    echo '<input type="number" id="num_products" name="num_products" value="' . esc_attr($num_products) . '" min="1" max="10"></p>';

    echo '<div id="product_reviews">';
    for ($i = 1; $i <= $num_products; $i++) {
        $name = get_post_meta($post->ID, "_product_{$i}_name", true);
        $effectiveness = get_post_meta($post->ID, "_product_{$i}_effectiveness", true);
        $safety = get_post_meta($post->ID, "_product_{$i}_safety", true);
        $price = get_post_meta($post->ID, "_product_{$i}_price", true);
        $rating = get_post_meta($post->ID, "_product_{$i}_rating", true);
        $description = get_post_meta($post->ID, "_product_{$i}_description", true);
        $image_url = get_post_meta($post->ID, "_product_{$i}_image", true);

        echo '<div class="product-review" ' . ($i === 1 ? 'style="border: 2px solid #007cba; padding: 10px;"' : '') . '>';
        echo '<h3>Product ' . $i . ($i === 1 ? ' (Best Product)' : '') . '</h3>';
        echo '<p><label for="product_' . $i . '_name">Name:</label> ';
        echo '<input type="text" id="product_' . $i . '_name" name="product_' . $i . '_name" value="' . esc_attr($name) . '"></p>';
        echo '<p><label for="product_' . $i . '_image">Image URL:</label> ';
        echo '<input type="text" id="product_' . $i . '_image" name="product_' . $i . '_image" value="' . esc_url($image_url) . '" class="product-image-url">';
        echo '<button type="button" class="upload-image-button button">Upload Image</button></p>';
        echo '<div class="image-preview">';
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width:400px;">';
        }
        echo '</div>';
        echo '<p><label for="product_' . $i . '_effectiveness">Effectiveness:</label> ';
        echo '<input type="text" id="product_' . $i . '_effectiveness" name="product_' . $i . '_effectiveness" value="' . esc_attr($effectiveness) . '"></p>';
        echo '<p><label for="product_' . $i . '_safety">Safety:</label> ';
        echo '<input type="text" id="product_' . $i . '_safety" name="product_' . $i . '_safety" value="' . esc_attr($safety) . '"></p>';
        echo '<p><label for="product_' . $i . '_price">Price:</label> ';
        echo '<input type="text" id="product_' . $i . '_price" name="product_' . $i . '_price" value="' . esc_attr($price) . '"></p>';
        echo '<p><label for="product_' . $i . '_rating">Overall Rating:</label> ';
        echo '<input type="text" id="product_' . $i . '_rating" name="product_' . $i . '_rating" value="' . esc_attr($rating) . '"></p>';
        echo '<p><label for="product_' . $i . '_description">Description:</label><br>';
        wp_editor($description, 'product_' . $i . '_description', array('textarea_name' => 'product_' . $i . '_description', 'textarea_rows' => 5));
        echo '</div>';
    }
    echo '</div>';

    echo '<p><label for="conclusion">Conclusion:</label><br>';
    wp_editor($conclusion, 'conclusion', array('textarea_name' => 'conclusion', 'textarea_rows' => 5));

    echo '<p><label for="cta_text">CTA Text:</label> ';
    echo '<input type="text" id="cta_text" name="cta_text" value="' . esc_attr($cta_text) . '"></p>';

    echo '<p><label for="cta_link">CTA Link:</label> ';
    echo '<input type="url" id="cta_link" name="cta_link" value="' . esc_url($cta_link) . '"></p>';

    // Add JavaScript for dynamic product fields and image upload
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var editorIndex = <?php echo $num_products; ?>;

        // Handle number of products change
        $('#num_products').on('change', function() {
            var num = $(this).val();
            var current = $('.product-review').length;
            if (num > current) {
                for (var i = current + 1; i <= num; i++) {
                    var newProduct = $('.product-review:first').clone();
                    newProduct.find('h3').text('Product ' + i + (i === 1 ? ' (Best Product)' : ''));
                    newProduct.find('input').val('').attr('name', function(index, name) {
                        return name.replace(/\d+/, i);
                    });
                    newProduct.find('.image-preview').empty();
                    
                    // Replace the cloned editor with a new one
                    newProduct.find('.wp-editor-area').parent().replaceWith(
                        '<textarea id="product_' + i + '_description" name="product_' + i + '_description"></textarea>'
                    );
                    
                    $('#product_reviews').append(newProduct);
                    
                    // Initialize new editor
                    wp.editor.initialize('product_' + i + '_description', {
                        tinymce: {
                            wpautop: true,
                            plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                            toolbar1: 'formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link unlink wp_more fullscreen wp_adv',
                            toolbar2: 'strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help'
                        },
                        quicktags: true,
                        mediaButtons: true
                    });

                    editorIndex++;
                }
            } else if (num < current) {
                $('.product-review').slice(num).each(function() {
                    var editorId = $(this).find('.wp-editor-area').attr('id');
                    wp.editor.remove(editorId);
                }).remove();
            }
        });

        // Handle image upload
        $(document).on('click', '.upload-image-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.siblings('.product-image-url').val(attachment.url);
                button.siblings('.image-preview').html('<img src="' + attachment.url + '" style="max-width:400px;">');
            });
            customUploader.open();
        });

        // Handle manual URL entry
        $(document).on('input', '.product-image-url', function() {
            var url = $(this).val();
            var preview = $(this).siblings('.image-preview');
            if (url) {
                preview.html('<img src="' + url + '" style="max-width:400px;">');
            } else {
                preview.empty();
            }
        });
    });
    </script>
    <?php

    log_message("Product review meta box callback completed for post ID: " . $post->ID);
}
 */

 // Version that works
/* 

function product_review_meta_box_callback($post) {
    try {
        log_message("Product review meta box callback started for post ID: " . $post->ID);
        wp_nonce_field('product_review_meta_box', 'product_review_meta_box_nonce');

        $num_products = get_post_meta($post->ID, '_num_products', true) ?: 5;
        $intro = get_post_meta($post->ID, '_intro_paragraph', true);
        $conclusion = get_post_meta($post->ID, '_conclusion', true);
        $cta_text = get_post_meta($post->ID, '_cta_text', true);
        $cta_link = get_post_meta($post->ID, '_cta_link', true);

        echo '<p><label for="intro_paragraph">Intro Paragraph:</label><br>';
        echo '<textarea id="intro_paragraph" name="intro_paragraph" rows="4" cols="50">' . esc_textarea($intro) . '</textarea></p>';

        echo '<p><label for="num_products">Number of Products:</label> ';
        echo '<input type="number" id="num_products" name="num_products" value="' . esc_attr($num_products) . '" min="1" max="10"></p>';

        echo '<div id="product_reviews">';
        for ($i = 1; $i <= $num_products; $i++) {
            $name = get_post_meta($post->ID, "_product_{$i}_name", true);
            $effectiveness = get_post_meta($post->ID, "_product_{$i}_effectiveness", true);
            $safety = get_post_meta($post->ID, "_product_{$i}_safety", true);
            $price = get_post_meta($post->ID, "_product_{$i}_price", true);
            $rating = get_post_meta($post->ID, "_product_{$i}_rating", true);
            $description = get_post_meta($post->ID, "_product_{$i}_description", true);
            $image_url = get_post_meta($post->ID, "_product_{$i}_image", true);

            echo '<div class="product-review" ' . ($i === 1 ? 'style="border: 2px solid #007cba; padding: 10px;"' : '') . '>';
            echo '<h3>Product ' . $i . ($i === 1 ? ' (Best Product)' : '') . '</h3>';
            echo '<p><label for="product_' . $i . '_name">Name:</label> ';
            echo '<input type="text" id="product_' . $i . '_name" name="product_' . $i . '_name" value="' . esc_attr($name) . '"></p>';
            echo '<p><label for="product_' . $i . '_image">Image URL:</label> ';
            echo '<input type="text" id="product_' . $i . '_image" name="product_' . $i . '_image" value="' . esc_url($image_url) . '" class="product-image-url">';
            echo '<button type="button" class="upload-image-button button">Upload Image</button></p>';
            echo '<div class="image-preview">';
            if ($image_url) {
                echo '<img src="' . esc_url($image_url) . '" style="max-width:400px;">';
            }
            echo '</div>';
            echo '<p><label for="product_' . $i . '_effectiveness">Effectiveness:</label> ';
            echo '<input type="text" id="product_' . $i . '_effectiveness" name="product_' . $i . '_effectiveness" value="' . esc_attr($effectiveness) . '"></p>';
            echo '<p><label for="product_' . $i . '_safety">Safety:</label> ';
            echo '<input type="text" id="product_' . $i . '_safety" name="product_' . $i . '_safety" value="' . esc_attr($safety) . '"></p>';
            echo '<p><label for="product_' . $i . '_price">Price:</label> ';
            echo '<input type="text" id="product_' . $i . '_price" name="product_' . $i . '_price" value="' . esc_attr($price) . '"></p>';
            echo '<p><label for="product_' . $i . '_rating">Overall Rating:</label> ';
            echo '<input type="text" id="product_' . $i . '_rating" name="product_' . $i . '_rating" value="' . esc_attr($rating) . '"></p>';
            echo '<p><label for="product_' . $i . '_description">Description:</label><br>';
            echo '<textarea id="product_' . $i . '_description" name="product_' . $i . '_description" rows="4" cols="50">' . esc_textarea($description) . '</textarea></p>';
            echo '</div>';
        }
        echo '</div>';

        echo '<p><label for="conclusion">Conclusion:</label><br>';
        echo '<textarea id="conclusion" name="conclusion" rows="4" cols="50">' . esc_textarea($conclusion) . '</textarea></p>';

        echo '<p><label for="cta_text">CTA Text:</label> ';
        echo '<input type="text" id="cta_text" name="cta_text" value="' . esc_attr($cta_text) . '"></p>';

        echo '<p><label for="cta_link">CTA Link:</label> ';
        echo '<input type="url" id="cta_link" name="cta_link" value="' . esc_url($cta_link) . '"></p>';

        // Add JavaScript for dynamic product fields and image upload
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Handle number of products change
            $('#num_products').on('change', function() {
                var num = $(this).val();
                var current = $('.product-review').length;
                if (num > current) {
                    for (var i = current + 1; i <= num; i++) {
                        var newProduct = $('.product-review:first').clone();
                        newProduct.find('h3').text('Product ' + i + (i === 1 ? ' (Best Product)' : ''));
                        newProduct.find('input, textarea').val('').attr('name', function(index, name) {
                            return name.replace(/\d+/, i);
                        });
                        newProduct.find('.image-preview').empty();
                        $('#product_reviews').append(newProduct);
                    }
                } else if (num < current) {
                    $('.product-review').slice(num).remove();
                }
            });

            // Handle image upload
            $(document).on('click', '.upload-image-button', function(e) {
                e.preventDefault();
                var button = $(this);
                var customUploader = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });
                customUploader.on('select', function() {
                    var attachment = customUploader.state().get('selection').first().toJSON();
                    button.siblings('.product-image-url').val(attachment.url);
                    button.siblings('.image-preview').html('<img src="' + attachment.url + '" style="max-width:400px;">');
                });
                customUploader.open();
            });

            // Handle manual URL entry
            $(document).on('input', '.product-image-url', function() {
                var url = $(this).val();
                var preview = $(this).siblings('.image-preview');
                if (url) {
                    preview.html('<img src="' + url + '" style="max-width:400px;">');
                } else {
                    preview.empty();
                }
            });
        });
        </script>
        <?php

        log_message("Product review meta box callback completed for post ID: " . $post->ID);
    } catch (Exception $e) {
        log_message("Error in product review meta box callback for post ID: " . $post->ID . ". Error: " . $e->getMessage());
    }
}

function save_product_review_meta($post_id) {
    try {
        log_message("Attempting to save product review meta for post ID: " . $post_id);

        if (!isset($_POST['product_review_meta_box_nonce']) || !wp_verify_nonce($_POST['product_review_meta_box_nonce'], 'product_review_meta_box')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = ['intro_paragraph', 'num_products', 'conclusion', 'cta_text', 'cta_link'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, "_{$field}", sanitize_text_field($_POST[$field]));
            }
        }

        $num_products = intval($_POST['num_products']) ?: 5;
        for ($i = 1; $i <= $num_products; $i++) {
            $product_fields = ['name', 'effectiveness', 'safety', 'price', 'rating', 'description', 'image'];
            foreach ($product_fields as $field) {
                $key = "product_{$i}_{$field}";
                if (isset($_POST[$key])) {
                    if ($field === 'image') {
                        update_post_meta($post_id, "_{$key}", esc_url_raw($_POST[$key]));
                    } else {
                        update_post_meta($post_id, "_{$key}", sanitize_text_field($_POST[$key]));
                    }
                }
            }
        }

        log_message("Product review meta saved for post ID: " . $post_id);
    } catch (Exception $e) {
        log_message("Error saving product review meta for post ID: " . $post_id . ". Error: " . $e->getMessage());
    }
}
 
 */


function product_review_meta_box_callback($post) {
    log_message("Product review meta box callback started for post ID: " . $post->ID);
    wp_nonce_field('product_review_meta_box', 'product_review_meta_box_nonce');

    $num_products = get_post_meta($post->ID, '_num_products', true) ?: 5;
    $intro = get_post_meta($post->ID, '_intro_paragraph', true);
    $conclusion = get_post_meta($post->ID, '_conclusion', true);
    $cta_text = get_post_meta($post->ID, '_cta_text', true);
    $cta_link = get_post_meta($post->ID, '_cta_link', true);

    echo '<h3>Sidebar Ad</h3>';
    echo '<p><label for="sidebar_ad_image">Ad Image URL: ($_sidebar_ad_image)</label> ';
    $sidebar_ad_image = get_post_meta($post->ID, '_sidebar_ad_image', true);
    echo '<input type="text" id="sidebar_ad_image" name="sidebar_ad_image" value="' . esc_url($sidebar_ad_image) . '" class="sidebar-ad-image-url">';
    echo '<button type="button" class="upload-sidebar-ad-button button">Upload Image</button></p>';
    echo '<div class="sidebar-ad-preview">';
    if ($sidebar_ad_image) {
        echo '<img src="' . esc_url($sidebar_ad_image) . '" class="sidebar-ad-image-preview">';
    }
    echo '</div>';

    echo '<p><label for="intro_paragraph">Intro Paragraph: ($_intro_paragraph)</label><br>';
    wp_editor($intro, 'intro_paragraph', array('textarea_name' => 'intro_paragraph', 'textarea_rows' => 10));

    echo '<p><label for="num_products">Number of Products: ($_num_products)</label> ';
    echo '<input type="number" id="num_products" name="num_products" value="' . esc_attr($num_products) . '" min="1" max="10"></p>';

    echo '<div id="product_reviews">';
    for ($i = 1; $i <= $num_products; $i++) {
        $name = get_post_meta($post->ID, "_product_{$i}_name", true);
        $effectiveness = get_post_meta($post->ID, "_product_{$i}_effectiveness", true);
        $safety = get_post_meta($post->ID, "_product_{$i}_safety", true);
        $price = get_post_meta($post->ID, "_product_{$i}_price", true);
        $rating = get_post_meta($post->ID, "_product_{$i}_rating", true);
        $description = get_post_meta($post->ID, "_product_{$i}_description", true);
        $image_url = get_post_meta($post->ID, "_product_{$i}_image", true);

        echo '<div class="product-review" ' . ($i === 1 ? 'style="border: 2px solid #007cba; padding: 10px;"' : '') . '>';
        echo '<h3>Product ' . $i . ($i === 1 ? ' (Best Product)' : '') . '</h3>';
        echo '<p><label for="product_' . $i . '_name">Name: (_product_' . $i . '_name)</label> ';
        echo '<input type="text" id="product_' . $i . '_name" name="product_' . $i . '_name" value="' . esc_attr($name) . '"></p>';
        echo '<p><label for="product_' . $i . '_image">Image URL: (_product_' . $i . '_image)</label> ';
        echo '<input type="text" id="product_' . $i . '_image" name="product_' . $i . '_image" value="' . esc_url($image_url) . '" class="product-image-url">';
        echo '<button type="button" class="upload-image-button button">Upload Image</button></p>';
        echo '<div class="image-preview">';
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width:400px;">';
        }
        echo '</div>';
        echo '<p><label for="product_' . $i . '_effectiveness">Effectiveness: (_product_' . $i . '_effectiveness)</label> ';
        echo '<input type="text" id="product_' . $i . '_effectiveness" name="product_' . $i . '_effectiveness" value="' . esc_attr($effectiveness) . '"></p>';
        echo '<p><label for="product_' . $i . '_safety">Safety: (_product_' . $i . '_safety)</label> ';
        echo '<input type="text" id="product_' . $i . '_safety" name="product_' . $i . '_safety" value="' . esc_attr($safety) . '"></p>';
        echo '<p><label for="product_' . $i . '_price">Price: (_product_' . $i . '_price)</label> ';
        echo '<input type="text" id="product_' . $i . '_price" name="product_' . $i . '_price" value="' . esc_attr($price) . '"></p>';
        echo '<p><label for="product_' . $i . '_rating">Overall Rating: (_product_' . $i . '_rating)</label> ';
        echo '<input type="text" id="product_' . $i . '_rating" name="product_' . $i . '_rating" value="' . esc_attr($rating) . '"></p>';
        echo '<p><label for="product_' . $i . '_description">Description: (_product_' . $i . '_description)</label><br>';
        wp_editor($description, "product_{$i}_description", array('textarea_name' => "product_{$i}_description", 'textarea_rows' => 10));
        echo '</div>';
    }
    echo '</div>';

    echo '<p><label for="conclusion">Conclusion: ($_conclusion)</label><br>';
    wp_editor($conclusion, 'conclusion', array('textarea_name' => 'conclusion', 'textarea_rows' => 10));

    echo '<p><label for="cta_text">CTA Text: ($_cta_text)</label> ';
    echo '<input type="text" id="cta_text" name="cta_text" value="' . esc_attr($cta_text) . '"></p>';

    echo '<p><label for="cta_link">CTA Link: ($_cta_link)</label> ';
    echo '<input type="url" id="cta_link" name="cta_link" value="' . esc_url($cta_link) . '"></p>';

    // Add JavaScript for dynamic product fields and image upload
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Handle sidebar ad image upload
        $(document).on('click', '.upload-sidebar-ad-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Choose Ad Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.siblings('.sidebar-ad-image-url').val(attachment.url);
                button.siblings('.sidebar-ad-preview').html('<img src="' + attachment.url + '" class="sidebar-ad-image-preview">');
            });
            customUploader.open();
        });

        // Handle manual URL entry for sidebar ad
        $(document).on('input', '.sidebar-ad-image-url', function() {
            var url = $(this).val();
            var preview = $(this).siblings('.sidebar-ad-preview');
            if (url) {
                preview.html('<img src="' + url + '" class="sidebar-ad-image-preview">');
            } else {
                preview.empty();
            }
        });
        
        // Handle number of products change
        $('#num_products').on('change', function() {
            var num = $(this).val();
            var current = $('.product-review').length;
            if (num > current) {
                for (var i = current + 1; i <= num; i++) {
                    var newProduct = $('.product-review:first').clone();
                    newProduct.find('h3').text('Product ' + i + (i === 1 ? ' (Best Product)' : ''));
                    newProduct.find('input, textarea').val('').attr('name', function(index, name) {
                        return name.replace(/\d+/, i);
                    });
                    newProduct.find('.image-preview').empty();
                    $('#product_reviews').append(newProduct);

                    // Initialize new editor
                    wp.editor.initialize('product_' + i + '_description', {
                        tinymce: {
                            wpautop: true,
                            plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                            toolbar1: 'formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link unlink wp_more fullscreen wp_adv',
                            toolbar2: 'strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help'
                        },
                        quicktags: true,
                        mediaButtons: true
                    });
                }
            } else if (num < current) {
                $('.product-review').slice(num).each(function() {
                    var editorId = $(this).find('.wp-editor-area').attr('id');
                    wp.editor.remove(editorId);
                }).remove();
            }
        });

        // Handle image upload
        $(document).on('click', '.upload-image-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.siblings('.product-image-url').val(attachment.url);
                button.siblings('.image-preview').html('<img src="' + attachment.url + '" style="max-width:400px;">');
            });
            customUploader.open();
        });

        // Handle manual URL entry
        $(document).on('input', '.product-image-url', function() {
            var url = $(this).val();
            var preview = $(this).siblings('.image-preview');
            if (url) {
                preview.html('<img src="' + url + '" style="max-width:400px;">');
            } else {
                preview.empty();
            }
        });
    });
    </script>
    <?php

    log_message("Product review meta box callback completed for post ID: " . $post->ID);
}

function save_product_review_meta($post_id) {
    log_message("Attempting to save product review meta for post ID: " . $post_id);

    if (!isset($_POST['product_review_meta_box_nonce']) || !wp_verify_nonce($_POST['product_review_meta_box_nonce'], 'product_review_meta_box')) {
        log_message("Nonce verification failed for post ID: " . $post_id);
        return;
    }
if (isset($_POST['sidebar_ad_image'])) {
    update_post_meta($post_id, '_sidebar_ad_image', esc_url_raw($_POST['sidebar_ad_image']));
}
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        log_message("Autosave detected, skipping meta save for post ID: " . $post_id);
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        log_message("User doesn't have permission to edit post ID: " . $post_id);
        return;
    }

    // Handle intro paragraph
    if (isset($_POST['intro_paragraph'])) {
        update_post_meta($post_id, '_intro_paragraph', wp_kses_post($_POST['intro_paragraph']));
        log_message("Saved intro paragraph for post ID: " . $post_id);
    }

    // Handle conclusion
    if (isset($_POST['conclusion'])) {
        update_post_meta($post_id, '_conclusion', wp_kses_post($_POST['conclusion']));
        log_message("Saved conclusion for post ID: " . $post_id);
    }

    // Handle CTA text and link
    if (isset($_POST['cta_text'])) {
        update_post_meta($post_id, '_cta_text', sanitize_text_field($_POST['cta_text']));
    }
    if (isset($_POST['cta_link'])) {
        update_post_meta($post_id, '_cta_link', esc_url_raw($_POST['cta_link']));
    }

    // Handle number of products
    if (isset($_POST['num_products'])) {
        $num_products = intval($_POST['num_products']);
        update_post_meta($post_id, '_num_products', $num_products);
    } else {
        $num_products = 5;
    }

    // Handle product details
    for ($i = 1; $i <= $num_products; $i++) {
        $product_fields = ['name', 'effectiveness', 'safety', 'price', 'rating', 'description', 'image'];
        foreach ($product_fields as $field) {
            $key = "product_{$i}_{$field}";
            if (isset($_POST[$key])) {
                if ($field === 'description') {
                    update_post_meta($post_id, "_{$key}", wp_kses_post($_POST[$key]));
                } elseif ($field === 'image') {
                    update_post_meta($post_id, "_{$key}", esc_url_raw($_POST[$key]));
                } else {
                    update_post_meta($post_id, "_{$key}", sanitize_text_field($_POST[$key]));
                }
            }
        }
    }

    log_message("Product review meta saved for post ID: " . $post_id);
}
 
add_action('save_post', 'save_product_review_meta');


// Debug template selection
function debug_template_selection($template) {
    log_message("debug_template_selection called");
    if (is_singular('post')) {
	    $post_id = get_the_ID();
	    $template_slug = get_page_template_slug($post_id);
        log_message("Post ID: $post_id, Template Slug: $template_slug, Actual template file: $template");
    } else {
        log_message("Not a singular post. Template: $template");
    }
    return $template;
}
add_filter('template_include', 'debug_template_selection', 99);

// Enqueue admin scripts

function enqueue_admin_scripts($hook) {
    global $post;

    if ($hook == 'post.php' || $hook == 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('product-review-admin-script', get_stylesheet_directory_uri() . '/js/product-review-admin.js', array('jquery'), '1.0', true);

        // Ensure localize script uses an array
        wp_localize_script('product-review-admin-script', 'productReviewAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('product_review_admin_nonce'),
        ));

        log_message("Admin scripts enqueued for post ID: " . $post->ID);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

// Add custom post format for product comparison
function add_product_comparison_post_format() {
    add_theme_support('post-formats', array('product-comparison'));
    log_message("Product comparison post format added");
}
add_action('after_setup_theme', 'add_product_comparison_post_format');

// Register custom post type for product reviews
function register_product_review_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Product Reviews',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'product-reviews'),
    );
    register_post_type('product_review', $args);
    log_message("Product review custom post type registered");
}
add_action('init', 'register_product_review_post_type');

// Add custom taxonomy for product categories
function register_product_category_taxonomy() {
    $args = array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'Product Categories',
            'singular_name' => 'Product Category',
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-category'),
    );
    register_taxonomy('product_category', 'product_review', $args);
    log_message("Product category taxonomy registered");
}
add_action('init', 'register_product_category_taxonomy');

// Add shortcode to display product review
function product_review_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
    ), $atts, 'product_review');

    $post_id = $atts['id'];

    if (!$post_id) {
        return 'No product review ID specified.';
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'product_review') {
        return 'Invalid product review ID.';
    }

    ob_start();
    include(locate_template('template-parts/content-product-review.php'));
    return ob_get_clean();
}
add_shortcode('product_review', 'product_review_shortcode');

// Add custom meta box for product review rating
function add_product_review_rating_meta_box() {
    add_meta_box(
        'product_review_rating',
        'Product Rating',
        'product_review_rating_callback',
        'product_review',
        'side',
        'default'
    );
    log_message("Product review rating meta box added");
}
add_action('add_meta_boxes', 'add_product_review_rating_meta_box');

function product_review_rating_callback($post) {
    $rating = get_post_meta($post->ID, '_product_rating', true);
    ?>
    <label for="product_rating">Rating (0-5):</label>
    <input type="number" name="product_rating" id="product_rating" value="<?php echo esc_attr($rating); ?>" min="0" max="5" step="0.1">
    <?php
    log_message("Product review rating meta box callback completed for post ID: " . $post->ID);
}

// Save product review rating
function save_product_review_rating($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['product_rating'])) {
        $rating = floatval($_POST['product_rating']);
        $rating = max(0, min(5, $rating)); // Ensure rating is between 0 and 5
        update_post_meta($post_id, '_product_rating', $rating);
        log_message("Product review rating saved for post ID: " . $post_id);
    }
}
add_action('save_post_product_review', 'save_product_review_rating');

// Add custom column to product review list
function add_product_review_columns($columns) {
    $columns['rating'] = 'Rating';
    return $columns;
}
add_filter('manage_product_review_posts_columns', 'add_product_review_columns');

// Populate custom column in product review list
function populate_product_review_columns($column, $post_id) {
    if ($column === 'rating') {
        $rating = get_post_meta($post_id, '_product_rating', true);
        echo $rating ? esc_html($rating) : 'N/A';
    }
}
add_action('manage_product_review_posts_custom_column', 'populate_product_review_columns', 10, 2);

// Add AJAX handler for dynamically adding product fields
function add_product_field_ajax_handler() {
    $index = isset($_POST['index']) ? intval($_POST['index']) : 0;
    ob_start();
    ?>
    <div class="product-review">
        <h3>Product <?php echo $index; ?></h3>
        <!-- Add your product fields here -->
    </div>
    <?php
    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_add_product_field', 'add_product_field_ajax_handler');

log_message("End of functions.php file");
