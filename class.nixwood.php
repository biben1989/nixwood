<?php

class NixwoodClass
{

    public  $price = 190;

    public $price_page = 100;

    public $total;

    public $quantity = 1;

    /**
     * @var bool
     */

    public function __construct() {

        add_shortcode('nixwood', array($this, 'nixwood_shortcode_callback'));
        add_action( 'wp_enqueue_scripts',  array($this, 'enqueue'));
        add_filter('nixwood_price',  array($this, 'price'));
        add_filter('nixwood_price_page',  array($this, 'pricePage'));

        add_action( 'wp_ajax_total_handle', array($this,'total_handle'));
        add_action( 'wp_ajax_nopriv_total_handle', array($this,'total_handle'));
    }

    public static function activatedPlugin(){
      flush_rewrite_rules();
    }

    public static function deactivationPlugin(){
        flush_rewrite_rules();
    }

    public function enqueue() {
        wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.6.1.min.js', false);
        wp_enqueue_script( 'nixwood.js', plugins_url( '_inc/nixwood.js',__FILE__), false);
        wp_enqueue_style( 'nixwood.css', plugins_url( '_inc/nixwood.css',__FILE__) , false );
        wp_localize_script( 'nixwood.js', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
    }

    public function pricePage(){
        return $this->price_page;
    }

    public function price(){
        return $this->price;
    }

    public function nixwood_shortcode_callback() {
        $this->setTotal($this->getPrice());
        ?>
        <div id="nixwood-checkout">
            <form id="checkout-nixwood_form" class="nixwood_form" action="">
                <div class="row">
                    <div class="col col-7">
                        <div class="nixwood_item">
                            <div class="nixwood__title">
                                Your card
                            </div>
                            <div class="nixwood_form_group">
                                <div class="checkbox-input">
                                    <input checked  class="checkbox" id="price" value="<?php echo $this->getPrice() ?>"   type="checkbox" name="price">
                                </div>
                                <div class="checkbox-text">
                                    <span class="nixwood_text nixwood_text_bold">Project name: Okirobo</span>
                                    <span class="nixwood_text nixwood_text_normal">One page (Base)</span>
                                </div>
                            </div>
                            <div class="nixwood_form_group">
                                <div class="checkbox-input">
                                    <input  type="checkbox" value="<?php  echo $this->getPricePage() ?>"  id="price_pages" name="price_pages">
                                </div>
                                <div class="checkbox-text">
                                    <span class="nixwood_text nixwood_text_bold">Add more pages</span>
                                    <span class="nixwood_text nixwood_text_normal">Number of additional pages</span>
                                </div>
                                <div class="nixwood_quantity">
                                    <span class="minus">-</span>
                                    <input name="quantity" id="quantity" type="text" value="<?php echo $this->getQuantity()?>"/>
                                    <span class="plus">+</span>
                                </div>
                            </div>
                            <div class="nixwood_order_total_button mobile-hide">
                                <button class="btn btn-silver" type="submit">Back to Project</button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-5">
                        <div class="nixwood_item">
                            <div class="nixwood__title">
                                Order summary
                            </div>
                            <div class="nixwood_total">
                                <div class="nixwood_total_texts">
                                    <div class="nixwood_total_text">
                                        <span class="nixwood_text nixwood_text_normal">Project name: Okirobo </span>
                                        <span  class="nixwood_text nixwood_text_normal" id="price">$<span><?php  echo $this->getPrice()?></span></span>
                                    </div>
                                    <div  class="nixwood_total_text nixwood_total_pages hidden">
                                        <span class="nixwood_text nixwood_text_normal"><span class="nixwood_total_pages_qnt"> </span> Number of additional pages</span>
                                        <span class="nixwood_text nixwood_text_normal"> $<span id="price_page"><?php  echo $this->getPricePage()?></span></span>
                                    </div>
                                </div>

                                <div class="nixwood_order_total">
                                    <span class="nixwood_text nixwood_text_bold">Total</span>
                                    <span class="nixwood_text nixwood_text_bold" ><span>US $</span>
                                         <span id="total"><?php echo $this->getTotal()?></span> </span>
                                </div>
                                <div class="nixwood_order_total_button">
                                    <button class="btn btn-red" type="submit">PAY</button>
                                    <button class="btn btn-silver" type="submit">Back to Project</button>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    public function getPrice(){
        return apply_filters('nixwood_price',$this->price());
    }

    public function getPricePage(){
        return apply_filters('nixwood_price_page',$this->pricePage());
    }
    public function setQuantity($qt){
        $this->quantity = $qt;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }


    public function getTotal(){
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function total_handle() {

      $total = $this->getPrice();

      $this->setQuantity($_POST['quantity']);

      if (isset($_POST['price_page']) && !empty($_POST['price_page'])){
          $total = $this->getPricePage() * $this->getQuantity() + $this->getPrice();
      }

      $this->setTotal($total);

      echo $this->getTotal();
        wp_die();
    }


}
