<!-- Update Client Modal -->
<div class="modal fade" id="updateClientModal" tabindex="-1" aria-labelledby="updateClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; background: linear-gradient(to bottom right, #d4f4dd, #e9f7eb);">
            <div class="modal-header border-0 text-center" style="display: block; padding: 1.5rem;">
                <h5 class="modal-title fw-bold" id="updateClientModalLabel" style="margin: 0; font-size: 1.5rem;">Update Client Details</h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form id="updateClientForm" action="{{ route('client.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="client-id">
                    
                    <div class="mb-3">
                        <label for="client-name" class="form-label" style="font-weight: 500;">Name</label>
                        <input type="text" class="form-control" name="name" id="client-name" required style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="client-details" class="form-label" style="font-weight: 500;">Client Details</label>
                        <textarea class="form-control" name="client_details" id="client-details" required style="border-radius: 8px; padding: 0.75rem;"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="client-email" class="form-label" style="font-weight: 500;">Email</label>
                        <input type="email" class="form-control" name="email" id="client-email" style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="client-phone" class="form-label" style="font-weight: 500;">Phone</label>
                        <input type="text" class="form-control" name="phone" id="client-phone" style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; background-color: #5cb85c; border-color: #5cb85c; font-weight: 500; padding: 0.75rem;">
                        Update Client
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
