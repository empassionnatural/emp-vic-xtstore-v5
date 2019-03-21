<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30/07/2018
 * Time: 9:11 AM
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function product_form($atts) {

    $bloglink = get_bloginfo('url');

    $html = '<div id="da-thumbs" class="da-thumbs">';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/ranges/signature-range/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_signature.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_signature.png">
                <p>Signature Range</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/ranges/lavender-range/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_lavender.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_lavender.png">
                <p>Lavander</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/aromatherapy/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_aromatherapy.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_aroma.png">
                <p>Aromatherapy</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/men/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_men.jpg" />';
    $html .= "<div class='overlay'><span></span></div>";
    $html .= "<div class='bg-color-txt-pic'>
                <img src='/wp-content/uploads/2018/09/icon_section_men.png'>
                <p>Men's Range</p>
              </div>";
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/teen-range/teen-boys/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_teen_boys.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_teenboys.png">
                <p>Teen Boys</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/teen-range/teen-girls/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_teen_girls.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_teengirls.png">
                <p>Teen Girls</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/kids/">';
    $html .= '<img src="/wp-content/uploads/2018/09/thumb_kids.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_kids.png">
                <p>Kids</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '<div class="box">';
    $html .= '<a href="product-category/age-ranges/baby/">';
    $html .= '<img src="/wp-content/uploads//2018/09/thumb_baby.jpg" />';
    $html .= '<div class="overlay"><span></span></div>';
    $html .= '<div class="bg-color-txt-pic">
                <img src="/wp-content/uploads/2018/09/icon_section_baby.png">
                <p>Baby</p>
              </div>';
    $html .= '</a>';
    $html .= '</div>';

    $html .= '</div>';

    return $html;

}
add_shortcode('product_form', 'product_form');

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

function if_login() {

    $boglink = get_bloginfo('url');

    if( !is_user_logged_in() ){
        echo do_shortcode( '[woocommerce_my_account]');
    }
    else {
        return redirect('https://qld.empassion.com.au/');
    }
}
add_shortcode( 'if_login', 'if_login' );

