<?php
/**
 * Created by "Unleashed Studios".
 * User: phi314
 * Date: 29/01/18
 * Time: 10:02
 */

include "lib/simple_html_dom.php";

/**
 * Class TiketDotCom
 */
class TiketDotCom {

    public $valid = false;
    public $url = '';
    public $html = '';
    public $price = '';
    public $gallery = [];
    private $aid = ''; // Tiket.com Bussiness ID

    function __construct( )
    {
        $this->set_tiket_dot_com_aid();
    }

    /**
     * Append Affiliate ID to Url
     * @param $url
     */
    public function set_url( $url ) {

        if( ! empty($url) ) {
            $this->url = $url . '?twh=' . $this->aid;
//            $this->set_html();
//
//            $this->set_price();
//            $this->set_gallery();
        }
    }

    private function set_tiket_dot_com_aid () {
        $this->aid = cmb2_get_option('cimahiwall_theme_options', 'tiket_dot_com_aid');
    }

    private function set_html() {
        $html = new simple_html_dom();
        $html->load_file($this->url);

        $this->html = $html;
    }

    private function set_price() {
        foreach ($this->html->find('.hright span.currency') as $element)
            $price = $element->plaintext;

        $this->price = $price;
    }

    private function set_gallery() {
        $gallery = [];
        if( ! empty($this->html) ) {
            foreach ($this->html->find('.cloud-zoom-gallery') as $element)
                $gallery[] = $element->href;

            $this->gallery = $gallery;
        }
    }
}

/**
 * Class BookingDotCom
 */
class BookingDotCom {

    public $url = '';
    private $aid = '';


    function __construct( )
    {
        $this->set_booking_dot_com_aid();
    }

    private function set_booking_dot_com_aid () {
        $this->aid = cmb2_get_option('cimahiwall_theme_options', 'booking_dot_com_aid');
    }

    /**
     * Append Affiliate ID to Url
     * @param $url
     */
    public function set_url( $url ) {
        $this->url = $url . '?aid=' . $this->aid ;
    }

    public function get_logo_url() {
        return "https://s-ec.bstatic.com/static/img/b26logo/booking_logo_retina/22615963add19ac6b6d715a97c8d477e8b95b7ea.png";
    }

}

/**
 * Class TiketDotCom
 */
class Zomato {

    private $api_key = 'c85cc0d90b677bfc3bae5355650daa94';
    public $zomato_place_id = '';
    public $json = '';
    public $url = '';

    function __construct( )
    {

    }

    /**
     * Set Zomato place id
     * @param $zomato_place_id
     */
    public function set_zomato_place_id( $zomato_place_id ) {

       $this->zomato_place_id = $zomato_place_id;
    }

    private function get_place_detail() {
        $html = new simple_html_dom( $this->url . '/menu' );
        if ( ! empty($html->root->attr ) ) {
            $this->html = $html;

            echo $html;
        }
    }

    private function set_menu() {
//        $menu_photos = [];
//        foreach ($this->html->find('#menu-image') as $element) {
//            $menu_photos[] = $element->find('img')->plaintext;
//        }
//
////        var_dump($menu_photos);
//
//        $this->menu = $menu_photos;
    }
}
