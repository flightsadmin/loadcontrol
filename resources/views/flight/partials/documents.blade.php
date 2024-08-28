<div class="container-fluid">
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Documents</h5>
                <div>
                    <select id="document-dropdown" class="form-select form-select-sm">
                        <option value="" disabled selected>Select a document</option>
                        <option value="loadsheet">Load Sheet</option>
                        <option value="loadplan">Load Plan</option>
                        <option value="loadmessage">Load Message</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <!-- Load Sheet Display -->
                <div id="loadsheet-content" style="display: none;">
                    @include('flight.partials.loadsheet')
                </div>

                <!-- Load Plan Display -->
                <div id="loadplan-content" style="display: none;">
                    @include('flight.partials.loadplan')
                </div>

                <!-- Load Message Display -->
                <div id="loadmessage-content" style="display: none;">
                    @include('flight.partials.loadmessage')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load the saved document choice from local storage
        const savedDocument = localStorage.getItem('selectedDocument');

        // Show the saved document content if available
        if (savedDocument) {
            document.getElementById('document-dropdown').value = savedDocument;
            displayDocument(savedDocument);
        }

        // Handle dropdown change
        document.getElementById('document-dropdown').addEventListener('change', function() {
            const selectedDocument = this.value;
            localStorage.setItem('selectedDocument', selectedDocument);
            displayDocument(selectedDocument);
        });

        // Function to display the selected document
        function displayDocument(documentType) {
            const loadsheetContent = document.getElementById('loadsheet-content');
            const loadplanContent = document.getElementById('loadplan-content');
            const loadmessageContent = document.getElementById('loadmessage-content');

            loadsheetContent.style.display = 'none';
            loadplanContent.style.display = 'none';
            loadmessageContent.style.display = 'none';

            if (documentType === 'loadsheet') {
                loadsheetContent.style.display = 'block';
            } else if (documentType === 'loadplan') {
                loadplanContent.style.display = 'block';
            } else if (documentType === 'loadmessage') {
                loadmessageContent.style.display = 'block';
            }
        }
    });
</script>
