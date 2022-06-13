<div class="dimmer active" style="min-height: 400px;">
  <div class="loader"></div>
  <div class="dimmer-content">
    <center><h2><?php echo lang('please_do_not_refresh_this_page'); ?></h2></center>
    <form method="post" action="https://www.2checkout.com/checkout/purchase" name="f1" id="payment_method_form">
        <input type='hidden' name='sid' value='1303908' >
        <input type='hidden' name='mode' value='2CO' >
        <input type='hidden' name='li_0_type' value='product' >
        <input type='hidden' name='li_0_name' value='Example Product Name' >
        <input type='hidden' name='li_0_product_id' value='Example Product ID' >
        <input type='hidden' name='li_0__description' value='Example Product Description' >
        <input type='hidden' name='li_0_price' value='10.00' >
        <input type='hidden' name='li_0_quantity' value='2' >
        <input type='hidden' name='li_0_tangible' value='N' >
        <input type='hidden' name='card_holder_name' value='Checkout Shopper' >
        <input type='hidden' name='street_address' value='123 Test St' >
        <input type='hidden' name='street_address2' value='Suite 200' >
        <input type='hidden' name='city' value='Columbus' >
        <input type='hidden' name='state' value='OH' >
        <input type='hidden' name='zip' value='43228' >
        <input type='hidden' name='country' value='USA' >
        <input type='hidden' name='email' value='example@2co.com' >
        <input type='hidden' name='phone' value='614-921-2450' >
        <input type='hidden' name='phone_extension' value='197' >
        <input type='hidden' name='purchase_step' value='payment-method' >
      <script type="text/javascript">
        $(function() {
          document.getElementById("payment_method_form").submit();
        });
      </script>
    </form>
  </div>
</div>