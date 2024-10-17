@if ($flight->loadsheet)
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-md-12" id="printable-content">
                    @include('loadsheet.loadsheet-data')
                </div>
            </div>
        </div>
    </div>

    {{-- Script to print documents as pdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        async function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            const element = document.getElementById("printable-content");

            const canvas = await html2canvas(element, {
                scale: 2
            });
            const imgData = canvas.toDataURL("image/png");

            const imgWidth = 190;
            const pageHeight = 297;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let heightLeft = imgHeight;

            let position = 10;
            doc.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            doc.save("{{ $flight->flight_number }} - loadsheet.pdf");
        }
    </script>
@else
    <div class="container mb-3">
        <p>Loadsheet not Finalised</p>
    </div>
@endif
