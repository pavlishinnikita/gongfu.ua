<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$categories = get_terms('product_cat');
?>
<form class="woocommerce-ordering" method="get">
    <div class="form-block filters">
        <select name="category" id="category_filter">
            <option value="">Виберіть категорію для фільтрації</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( $_GET['category'] ?? '', $category->slug ); ?> ><?php echo esc_html( $category->name ); ?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-block">
        <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
            <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="paged" value="1" />
    </div>
    <div class="buttons-block">
        <button class="filter-from-submit"><?= __("Apply") ?></button>
    </div>
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page', 'category' ) ); ?>
</form>
<script>
    jQuery(function () {
        jQuery('#page form.woocommerce-ordering').off('change').on('change', 'select.orderby', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        });
    });
    jQuery('.filter-from-submit').on('click', function (e) {
        jQuery(e.target).closest('form').submit();
    });
</script>
