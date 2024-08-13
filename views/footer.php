<?php include("../footer.php") ?>

    <!-- BEGIN VENDOR JS-->
    <script src="../app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="../app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/jquery-sliding-menu.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/sliders/slick/slick.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/forms/select/selectivity-full.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/forms/tags/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/forms/tags/tagging.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/extensions/sweetalert.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="../app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="../app-assets/js/core/app.js" type="text/javascript"></script>
    <script src="../app-assets/js/scripts/ui/fullscreenSearch.js" type="text/javascript"></script>
    <script src="../app-assets/js/scripts/forms/select/form-selectivity.js" type="text/javascript"></script>
    <script src="../app-assets/js/scripts/pages/email-application.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <script src="../app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="../app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js" type="text/javascript"></script>
    <script>
        $('.solicitud').on('click', function(event){
            var item = $(this).data('idsolic');
            $('#af-main').css("display", 'none');
            $('#af-detalle').css("display", 'block');
        });

    </script>
    <script>
        $(document).ready(() => {
        let count=2;
 
        // Adding row on click to Add New Row button
        $('#addBtn').click(function () {
            let dynamicRowHTML = `
            <tr id="af-${count}" class="rowClass">
                <td>
                    <div class="">
                        <!-- <label for="noplaca" class="form-label">No Placa</label> -->
                        <input type="text" class="form-control" name="noplaca[]" placeholder="ABC123456">
                    </div>
                </td>
                <td>
                    <div class="">
                        <!-- <label for="noserie" class="form-label">No Placa</label> -->
                        <input type="text" class="form-control" name="noserie[]" placeholder="ABC123456">
                    </div>
                </td>
                <td class="remove-btn">
                    <button class="btn btn-danger remove" type="button" data="af-${count}" id="rmvbtn"> - </button>
                </td>
            </tr>`;
            $('#dynamic-info').append(dynamicRowHTML);
            count++;
        });

        // Removing Row on click to Remove button
        $(document).on('click', '.remove', function () {
            var button_id = $(this).attr("data");
            $('#'+button_id+'').remove();
            //$(this).parent('td.remove-btn').parent('tr.rowClass').remove(); 
        });
    });
    </script>
    </body>
</html>
