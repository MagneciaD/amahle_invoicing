<x-app-layout>
    <div class="container">
        <h3 class="text-center text-dark fw-bold display-5">Choose Invoice Templates</h3> <!-- Slightly smaller title -->
        <form action="{{ route('invoices.generatePDF', ['invoiceId' => $invoice->id]) }}" method="POST" id="template-form">
            @csrf
            <div class="form-group">
                <label for="template"></label>
            </div>

            <div class="row mt-3 justify-content-center"> <!-- Added justify-content-center to center the templates -->
                <!-- Template 1 -->
                <div class="col-md-2 col-sm-4 p-1"> <!-- Adjusted column size and padding -->
                    <div class="template-card" onclick="selectTemplate('template1', this)" style="border: 2px solid transparent; border-radius: 5px; cursor: pointer; max-width: 200px; margin: auto; transition: transform 0.3s, box-shadow 0.3s;">
                        <img alt="Invoice Template 1" class="shadow img-fluid" src="{{ asset('img/invoicetemp2.png') }}" style="max-width: 100%; height: auto;">
                        <input type="radio" name="template" value="template1" id="template1" style="display:none;">
                        <label for="template1" class="template-label">Template 1</label>
                    </div>
                </div>

                <!-- Template 2 -->
                <div class="col-md-2 col-sm-4 p-1">
                    <div class="template-card" onclick="selectTemplate('template2', this)" style="border: 2px solid transparent; border-radius: 5px; cursor: pointer; max-width: 200px; margin: auto; transition: transform 0.3s, box-shadow 0.3s;">
                        <img alt="Invoice Template 2" class="shadow img-fluid" src="{{ asset('img/invoicetemp1.png') }}" style="max-width: 100%; height: auto;">
                        <input type="radio" name="template" value="template2" id="template2" style="display:none;">
                        <label for="template2" class="template-label">Template 2</label>
                    </div>
                </div>

                <!-- Template 3 -->
                <div class="col-md-2 col-sm-4 p-1">
                    <div class="template-card" onclick="selectTemplate('template3', this)" style="border: 2px solid transparent; border-radius: 5px; cursor: pointer; max-width: 200px; margin: auto; transition: transform 0.3s, box-shadow 0.3s;">
                        <img alt="Invoice Template 2" class="shadow img-fluid" src="{{ asset('img/invoicetemp3.png') }}" style="max-width: 100%; height: auto;">
                        <input type="radio" name="template" value="template3" id="template3" style="display:none;">
                        <label for="template3" class="template-label">Template 3</label>
                    </div>
                </div>

                <!-- Template 4 -->
                <div class="col-md-2 col-sm-4 p-1">
                    <div class="template-card" onclick="selectTemplate('template4', this)" style="border: 2px solid transparent; border-radius: 5px; cursor: pointer; max-width: 200px; margin: auto; transition: transform 0.3s, box-shadow 0.3s;">
                        <img alt="Invoice Template Za Classic White" class="shadow img-fluid" src="https://templates.invoicehome.com/invoice-template-za-classic-white-750px.png" style="max-width: 100%; height: auto;">
                        <input type="radio" name="template" value="template4" id="template4" style="display:none;">
                        <label for="template4" class="template-label">Template 4</label>
                    </div>
                </div>

                <!-- Template 5 -->
                <div class="col-md-2 col-sm-4 p-1">
                    <div class="template-card" onclick="selectTemplate('template5', this)" style="border: 2px solid transparent; border-radius: 5px; cursor: pointer; max-width: 200px; margin: auto; transition: transform 0.3s, box-shadow 0.3s;">
                        <img alt="Invoice Template Za Classic White" class="shadow img-fluid" src="https://templates.invoicehome.com/invoice-template-za-classic-white-750px.png" style="max-width: 100%; height: auto;">
                        <input type="radio" name="template" value="template5" id="template5" style="display:none;">
                        <label for="template5" class="template-label">Template 5</label>
                    </div>
                </div>

                <!-- Add more templates as needed -->
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Generate PDF</button>
            </div>
        </form>

        <script>
            function selectTemplate(template, card) {
                // Set the corresponding radio button as checked
                const input = document.querySelector(`input[name="template"][value="${template}"]`);
                input.checked = true;

                // Clear previous selections
                const cards = document.querySelectorAll('.template-card');
                cards.forEach(c => {
                    c.style.borderColor = 'transparent'; // Reset border color
                });

                // Highlight the selected template card
                card.style.borderColor = '#007bff'; // Bootstrap primary color for the selected card
            }
        </script>

        <style>
            /* 3D Hover Effect */
            .template-card:hover {
                transform: translateY(-10px); /* Moves the card up */
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Creates a shadow for depth */
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }
        </style>
    </div>
</x-app-layout>
