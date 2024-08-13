<script>
    function iniciar(texto){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../recibir_lectura_qr.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('servicio').innerHTML = xhr.responseText;
            }
        };
        xhr.send('info_servicio=' + encodeURIComponent("1-2"));
    }
</script>

<div class="col-sm-12 col-md-3">
    <center><a href="#!" id="open_qr"><img src="../assets/icons/qr.png" alt="QR" style="width: 35px; margin: 10px;"></a>
    <div id="servicio"></div></center>
</div>
<div class="card-body">
    <div id="qr-cam"></div>
</div>

<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>

<script src="js/html5-qrcode.min.js" type="text/javascript"></script>
<script>
    $( "#open_qr" ).on( "click", function() {
        $('#qr-cam').append('<div id="qr-reader" style="width:100%;"></div><div id="qr-reader-results"></div>');
        function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete" || document.readyState === "interactive") {
                // call on next available tick
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        } 

        docReady(function() {
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;
            
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", { fps: 10, qrbox: 250 });
            
            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    console.log(`Scan result = ${decodedText}`, decodedResult);
        
                    //resultContainer.innerHTML += `<button type="button" class="btn btn-success" data-toggle="modal" data-target="#edititemreportqr" data-revid="<? echo $idrevision; ?>" data-reco="<? echo $idrecorrido; ?>" data-link="${decodedText}">Reporte de Item</button>`;
                    //resultContainer.innerHTML += "<p>Scan result = " + decodedText + "</p>"
                    //$('#edititemreport').modal('show');
                    
                    
                    // Optional: To close the QR code scannign after the result is found
                    html5QrcodeScanner.clear();

                    iniciar(decodedText);

                    //window.location='../recibir_lectura_qr.php';
                }
            }
            
            // Optional callback for error, can be ignored.
            function onScanError(qrCodeError) {
                // This callback would be called in case of qr code scan error or setup error.
                // You can avoid this callback completely, as it can be very verbose in nature.
            }
            
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });
    } );
</script>