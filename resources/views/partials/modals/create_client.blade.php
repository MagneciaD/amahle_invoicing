<!-- resources/views/partials/modals/create_client.blade.php -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
<div class="modal-dialog" style="max-width: 500px; width: 80%; max-height: 500px;"> <!-- Custom width and height -->
<form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden; background: linear-gradient(to bottom right, #d4f4dd, #e9f7eb);">
                <div class="modal-header border-0 text-center" style="display: block; padding: 1.5rem;">
                    <h5 class="modal-title fw-bold" id="clientModalLabel" style="margin: 0; font-size: 1.5rem;">Add New Client</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-weight: 500;">Client Name</label>
                        <input type="text" class="form-control" id="name" name="name" required style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="client_details" class="form-label" style="font-weight: 500;">Client Details</label>
                        <textarea class="form-control" id="client_details" name="client_details" required style="border-radius: 8px; padding: 0.75rem;"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-weight: 500;">Email (optional)</label>
                        <input type="email" class="form-control" id="email" name="email" style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label" style="font-weight: 500;">Phone (optional)</label>
                        <input type="text" class="form-control" id="phone" name="phone" style="border-radius: 8px; padding: 0.75rem;">
                    </div>
                    
                    <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">
                </div>
                <div class="modal-footer border-0" style="padding: 1.5rem; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" style="border-radius: 8px; background-color: #5cb85c; border-color: #5cb85c; font-weight: 500; padding: 0.5rem 1rem; margin-left: 0.5rem;">
                        Save Client
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
