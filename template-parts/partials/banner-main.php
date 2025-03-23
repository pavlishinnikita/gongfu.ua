<?php

if (!defined('ABSPATH')) exit;

$background = !empty($args['background']) ? esc_url($args['background']) : '';
$text = !empty($args['text']) ? esc_html($args['text']) : 'Default Text';
$button_text = !empty($args['button_text']) ? esc_html($args['button_text']) : 'Click Here';
$button_link = !empty($args['button_link']) ? esc_url($args['button_link']) : '#';
$sub_text = !empty($args['sub_text']) ? esc_html($args['sub_text']) : '';
$imageUrl = !empty($args['image_url']) ? esc_url($args['image_url']) : '';
?>

<div class="main-banner" style="background-image: url('<?= esc_url($background); ?>');">
    <div class="banner-content">
        <div class="info">
            <h2>
                <span class="main-text"><?= esc_html($text); ?></span>
            </h2>
            <span class="sub-text"><?= esc_html($sub_text); ?></span>
            <a href="<?= esc_url($button_link); ?>" class="banner-button"><?= esc_html($button_text); ?></a>
        </div>
        <div class="image">
            <?php if(!empty($imageUrl)): ?>
                <img src="<?= $imageUrl?>" alt="">
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* MAIN BANNER STYLES */
    .main-banner {
        position: relative;
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        margin-bottom: 50px;
    }

    .banner-content {
        display: flex;
        flex-direction: row;
        padding: 20px;
        border-radius: 5px;
        align-items: center;
        justify-content: center;
        gap: 0 10px;
    }

    .banner-content h2 {
    }

    .banner-content .info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .banner-content .image {
        height: auto;
        max-height: 100%;
        width: auto;
        max-width: 100%;
        object-fit: contain;
    }

    /**/
    .main-banner {
        display: flex;
        align-items: stretch;
        justify-content: space-between;
        width: 100%;
        background-size: cover;
        padding: 20px;
    }

    .banner-content {
        display: flex;
        width: 100%;
    }

    .info {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
    }

    .image {
        flex: 5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .banner-content h2 span.main-text {
        font-size: xxx-large;
        max-width: 50%;
        text-align: left;
    }

    .banner-content h2 span.sub-text {
        text-align: left;
        font-size: large;
        align-self: center;
    }

    .banner-content .banner-button {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #000000;
        color: #ffffff;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        width: 50%
    }

    .banner-content .banner-button:hover {
        color: #000000;
        background-color: #ffffff;
    }
</style>