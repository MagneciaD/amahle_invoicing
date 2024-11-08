<!-- payment_modal.blade.php -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; background: linear-gradient(to bottom right, #b2e0c5, #d9f2e6); color: #333; max-width: 400px; margin: auto;">
            <div class="modal-header border-0 text-center" style="display: block;">
                <h5 class="modal-title fw-bold text-center" id="paymentModalLabel" style="margin: 0;">Make a Payment</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form action="" method="POST" id="payfastForm">
                    @csrf
                    <!-- PayFast Fields -->
                    <input type="hidden" name="merchant_id" value="your_merchant_id">
                    <input type="hidden" name="merchant_key" value="your_merchant_key">
                    <input type="hidden" name="return_url" value="">
                    <input type="hidden" name="cancel_url" value="">
                    <input type="hidden" name="notify_url" value="">
                    <input type="hidden" name="amount" value="100.00"> <!-- Change as needed -->
                    <input type="hidden" name="item_name" value="Payment for Services"> <!-- Change as needed -->

                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-weight: 500;">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; background-color: #4CAF50; border: none;">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
