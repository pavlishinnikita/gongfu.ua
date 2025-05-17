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

<header class="woocommerce-products-header">

	<?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action( 'woocommerce_archive_description' );
	?>

</header>

<?php

    if ( woocommerce_product_loop() ) {
        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action( 'woocommerce_before_shop_loop' );
        woocommerce_product_loop_start();

        if ( wc_get_loop_prop( 'total' ) ) {

            while ( have_posts() ) {
                the_post();
                /**
                 * Hook: woocommerce_shop_loop.
                 *
                 * @hooked WC_Structured_Data::generate_product_data() - 10
                 */
                do_action( 'woocommerce_shop_loop' );
                wc_get_template_part( 'content', 'product' );
            }
        }

        woocommerce_product_loop_end();

        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action( 'woocommerce_after_shop_loop' );

    } else {

        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action( 'woocommerce_no_products_found' );
    }

?>

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
