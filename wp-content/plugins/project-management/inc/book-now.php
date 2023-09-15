<?php
// var_dump(time());
// var_dump(get_current_user_id());
$cus_data = get_userdata(get_current_user_id());
// var_dump($cus_data); ====> bool
if ($cus_data) {
  $cus_email = $cus_data->user_email;
  $tour_slot_remain = (int)get_post_meta(get_the_ID(), '_tour_slot_remain', true);
  // console.log("🚀 ~ cus_email:", cus_email);
  // var_dump($cus_email == null); ====> true
?>
  <!-- Button trigger modal -->
  <div class="d-flex justify-content-center">
    <button <?php if ($tour_slot_remain<=0) {?> disabled <?php }?> type="button" style="background-color: #f2b129;" class="btn btn-primary w-75 p-3 text-white fw-bold border-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Book now
    </button>
  </div>

  <!-- Modal -->
  <form name="customer_infor" id="customer_infor">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Customer information</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input name="cus_name" id="cus_name" class="border-1" style="border: 2px solid #ccc" placeholder="Name" type="text">
            <input name="cus_phone" id="cus_phone" class="border-1" style="border: 2px solid #ccc" placeholder="Phone" type="tel">
            <input name="cus_quantity" id="cus_quantity" max="<?= $tour_slot_remain ?>" class="border-1" style="border: 2px solid #ccc" placeholder="Quantity" type="number">
            <select name="cus_payment" id="cus_payment" style="border: 1px solid #ccc">
              <option value="0">COD</option>
              <option value="1">Transfer</option>
            </select>
          </div>
          <input id="tour_slot_remain" value="<?= $tour_slot_remain ?>" type="hidden">
          <input id="cus_mail" value="<?= $cus_email ?>" type="hidden">
          <input id="tourID" value="<?= get_the_ID() ?>" type="hidden">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input name="save_customer_infor" id="save_customer_infor" type="submit" class="btn btn-primary">
          </div>
        </div>
      </div>
    </div>
  </form>
<?php
} else {
?>
<!-- Button trigger modal -->
<div class="d-flex justify-content-center">
    <a id="book_now_btn" href="http://localhost/wordpress/signin" style="background-color: #f2b129;" class="btn btn-primary w-75 p-3 text-white fw-bold border-0">
      Book now
    </a>
</div>
<?php
}
?>


<script>
    jQuery(document).ready(function() {
        $('#customer_infor').validate({
        rules: {
            cus_name: { required: true },
            cus_phone: { required: true },
            cus_quantity: {
                required: true,
                min: 1,
            }
        },
        messages: {
            cus_name: { required: "This field is required" },
            cus_phone: { required: "This field is required" },
            cus_quantity: {
                required: "This field is required",
                min: "Please enter a valid number",
            }
        }
    });
    })
</script>