
// check is user buy specific product or not then apply special coupon which one created bellow 
add_action( 'woocommerce_before_cart', 'bbloomer_apply_coupon_new' );
function bbloomer_apply_coupon_new() {
	global $woocommerce;
	global $product;
	$user = wp_get_current_user();
    $product_Id = '765';
    $coupon_name = 'TestSubCop';
    // $product = wc_get_product( $product_Id );
    $coupon_code = new WC_Coupon( $coupon_code ); 
	if( wc_customer_bought_product( wp_get_current_user()->user_email, get_current_user_id(),  $product_Id  ) ){
    echo "<p>This user have already purchased one of this products</p>";
    WC()->cart->apply_coupon( $coupon_name );
    wc_print_notices();
    var_dump( $product);
    }

    else{
    echo "<p>This user have not yet purchased one of this products</p>";

}

// get user mail and push to woocommerce coupon 
add_action('woocommerce_thankyou', 'send_product_purchase_notification');
function send_product_purchase_notification($orderId)
{
    global $woocommerce;
	global $product;

    $order = new WC_Order($orderId);
    
    foreach ($order->get_items() as $item) {
        $product_id = (is_object($item)) ? $item->get_product_id() : $item['product_id'];
        $user = wp_get_current_user();
        if ($product_id == 765) {
    
            $coupon_code = 'TestCopNEw';
            // $user = wp_get_current_user()->user_email;//Get the current user object
            $coupon = new WC_Coupon( $coupon_code );//Get the coupon object
            $emails = $coupon->get_email_restrictions();//Returns an empty array or array of emails
            $emails[] = strtolower($user->billing_email);//Add user's billing email address to the array
            $emails = array_filter($emails);//Remove empty values
            array_unique($emails);//Remove any duplicate values
            $coupon->set_email_restrictions($emails);//Set the coupon's array with the updated array
            $coupon->save();//Save the coupon
            
            return true;


        }
    }
}