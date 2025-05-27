<?php

?>

<table role="presentation" style="background-color: #f9f9f9; padding: 40px 0; text-align: center;">
    <tr>
        <td">
            <table role="presentation" style="background-color: #ffffff; padding: 30px; border-radius: 8px; text-align: center;">
                <tr>
                    <td style="border: none;">
                        <h2 style="margin: 20px 0;">Привіт, <?= esc_html($customerName)?>, ми тільки що додали новий товар у наш магазин</h2>
                        <p style="font-size: 18px; margin: 10px 0;">Встигни замовити <?= esc_html($product->get_name()); ?>. Клікай на кнопку нижче та замовляй</p>
                        <div>
                            <?= $product->get_image( 'woocommerce_thumbnail' ) ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 0; border: none;">
                        <!-- Buy Button -->
                        <a href="<?= esc_url( get_permalink($product->get_id())); ?>" style="
                          display: inline-block;
                          background-color: #0c0c0c;
                          color: #ffffff;
                          padding: 15px 30px;
                          text-decoration: none;
                          font-size: 18px;
                          border-radius: 5px;
                        ">
                            Замовити зараз 🛒
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="border: none;">
                        <!-- Footer -->
                        <hr style="margin: 40px 0; border: none; border-top: 1px solid #ddd;">
                        <p style="font-size: 12px; color: #666;">
                            &copy; <?= date('Y') ?> <?= esc_html(get_bloginfo('name')) ?>.<br>
                            Завітайте до нас: <a href="<?= esc_url(home_url()) ?>"><?= esc_html(home_url()) ?></a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
