<?php

/**
 * The Template for displaying product archives, including the shop page, category pages, and more.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );

?>

    <div class="category-section">
        <?php

        $categories = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
        ]);

        if (!empty($categories)) : ?>
            <div class="category-list">
                <?php foreach ($categories as $category) : ?>
                    <div class="category-item">
                        <a href="<?php echo get_term_link($category); ?>" class="category-link">
                            <?php
                            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                            if ($thumbnail_id) {
                                echo wp_get_attachment_image($thumbnail_id, 'medium');
                            }
                            ?>
                            <h3 class="category-title"><?php echo esc_html($category->name); ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <hr>

    <div class="new-arrivals-section">
        <h2><?=__("Нові надходження")?></h2>
        <div class="new-arrivals-slider">
            <?php echo do_shortcode('[products limit="6" columns="3" orderby="date" order="DESC"]'); ?>
        </div>
    </div>

    <div class="most-popular-section">
        <h2><?=__("Популярні товари")?></h2>
        <div class="most-popular-slider">
            <?php echo do_shortcode('[products limit="6" columns="3" orderby="popularity"]'); ?>
        </div>
    </div>

<?php
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );

?>
<script>
    jQuery(document).ready(function($) {
        $('.new-arrivals-slider ul.products').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        $('.most-popular-slider ul.products').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
</script>

<style>
    .new-arrivals-section, .most-popular-section {
        margin-top: 40px;
    }

    .slick-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .slick-prev, .slick-next {
        color: #000;
    }

    .slick-prev:before, .slick-next:before {
        font-size: 20px;
    }

    .slick-dots {
        bottom: -30px;
    }

    .slick-dots li button:before {
        color: #000;
    }

    .category-item .category-title, .category-section h2, .new-arrivals-section h2, .most-popular-section h2 {
        color: var(--main-text-color);
    }
    .category-list {
        display: flex;
        justify-content: space-around;
    }

    .most-popular-slider ul.products, .new-arrivals-slider ul.products {
        display: flex !important;
        align-items: stretch;
    }
    .most-popular-slider .slick-slide, .new-arrivals-slider .slick-slide {
        height: auto !important;
        margin: 0 10px;
    }

    .most-popular-slider .slick-track, .new-arrivals-slider .slick-track {
        display: flex !important;
    }

    .most-popular-slider .slick-list, .new-arrivals-slider .slick-list {
        margin: 0 -10px !important;
    }

    .most-popular-slider li.product, .new-arrivals-slider li.product {
        height: 100% !important;
        margin: 0 20px !important;
    }

    .most-popular-slider .product-info-wrap .woocommerce-loop-product__title, .new-arrivals-slider .product-info-wrap .woocommerce-loop-product__title {
        color: black;
    }

</style>
