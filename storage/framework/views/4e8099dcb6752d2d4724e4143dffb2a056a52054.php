<!-- jQuery -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/js/bootstrap-select.js"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>

<!-- Slimscroll JS -->
<script src="<?php echo e(asset('js/jquery.slimscroll.min.js')); ?>"></script>
<!-- Select2 JS -->
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.ui.touch-punch.min.js')); ?>"></script>

<!-- Datetimepicker JS -->
<script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>

<!-- Calendar JS -->
<script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/fullcalendar.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.fullcalendar.js')); ?>"></script>

<!-- Multiselect JS -->
<script src="<?php echo e(asset('js/multiselect.min.js')); ?>"></script>

<!-- Datatable JS -->

<script src="<?php echo e(asset('js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.1.1/b-html5-2.1.1/r-2.2.9/sc-2.0.5/datatables.min.css"/>

<script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.1.1/b-html5-2.1.1/r-2.2.9/sc-2.0.5/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<!-- Summernote JS -->
<script src="<?php echo e(asset('plugins/summernote/dist/summernote-bs4.min.js')); ?>"></script>


<script src="<?php echo e(asset('plugins/sticky-kit-master/dist/sticky-kit.min.js')); ?>"></script>

<!-- Task JS -->
<script src="<?php echo e(asset('js/task.js')); ?>"></script>

<!-- Dropfiles JS
<script src="js/dropfiles.js"></script> -->

<!-- Custom JS -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>


<script>
    $('.summernote').summernote({
        placeholder: 'Text Goes Here...!',
        tabsize: 1,
        height: 100,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],

        ]
    });
</script>


<script>

    $(document).ready(function () {
        $('#summernote').summernote();
    });


    // Read value on page load
    $("#result b").html($("#customRange").val());

    // Read value on change
    $("#customRange").change(function () {
        $("#result b").html($(this).val());
    });
    $(".header").stick_in_parent({});
    // This is for the sticky sidebar
    $(".stickyside").stick_in_parent({
        offset_top: 60
    });
    $('.stickyside a').click(function () {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 60
        }, 500);
        return false;
    });

    var lastId,
        topMenu = $(".stickyside"),
        topMenuHeight = topMenu.outerHeight(),
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function () {
            var item = $($(this).attr("href"));
            if (item.length) {
                return item;
            }
        });

    // Bind to scroll
    $(window).scroll(function () {
        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight - 250;

        // Get id of current scroll item
        var cur = scrollItems.map(function () {
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .removeClass("active")
                .filter("[href='#" + id + "']").addClass("active");
        }
    });
    $(function () {
        $(document).on("click", '.btn-add-row', function () {
            var id = $(this).closest("table.table-review").attr('id');  // Id of particular table
            console.log(id);
            var div = $("<tr />");
            div.html(GetDynamicTextBox(id));
            $("#" + id + "_tbody").append(div);
        });
        $(document).on("click", "#comments_remove", function () {
            $(this).closest("tr").prev().find('td:last-child').html('<button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button>');
            $(this).closest("tr").remove();
        });

        function GetDynamicTextBox(table_id) {
            $('#comments_remove').remove();
            var rowsLength = document.getElementById(table_id).getElementsByTagName("tbody")[0].getElementsByTagName("tr").length + 1;
            return '<td>' + rowsLength + '</td>' + '<td><input type="text" name = "DynamicTextBox" class="form-control" value = "" ></td>' + '<td><input type="text" name = "DynamicTextBox" class="form-control" value = "" ></td>' + '<td><input type="text" name = "DynamicTextBox" class="form-control" value = "" ></td>' + '<td><button type="button" class="btn btn-danger" id="comments_remove"><i class="fa fa-trash-o"></i></button></td>'
        }
    });


</script>
<style>
    table.dataTable thead th {
        position: relative;
        background-image: none !important;
    }

    table.dataTable thead th.sorting:after,
    table.dataTable thead th.sorting_asc:after,
    table.dataTable thead th.sorting_desc:after {
        position: absolute !important;
        top: 12px !important;
        right: 8px !important;
        display: block !important;
        font-family: FontAwesome !important;
    }

    table.dataTable thead th.sorting:after {
        content: "\f0dc" !important;
        color: #ddd !important;
        font-size: 0.8em !important;
        padding-top: 0.12em !important;
    }

    table.dataTable thead th.sorting_asc:after {
        content: "\f0de" !important;
    }

    table.dataTable thead th.sorting_desc:after {
        content: "\f0dd" !important;
    }
</style>

<script>
    $(document).ready(function () {
        $('#data_table').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5', 'pdf'
            ],
            initComplete: function () {
                var btns = $('.dt-button');
                btns.addClass('btn btn-secondary dt');
                btns.removeClass('dt-button');
            },
        });
    });
    $(document).ready(function () {
        var multipleCancelButton = new Choices('#multiple', {
            removeItemButton: true,
            maxItemCount: 3,
            searchResultLimit: 10,
            renderChoiceLimit: 10,
        });
    });
    $(function () {
        $('.toggle-class').change(function () {
            var is_active = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');
            var lastDate = $(this).val();
            var today = moment(new Date()).format("YYYY-MM-DD")
            if (lastDate < today) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hiring Request Expired!',
                    text: 'This hiring request has been expired. Please update job expiry date to re-active this Hiring Request',
                    footer: '<a target="_blank" href="https://209.97.168.200/hr/public/hiringRequestAuthenticateForm/' + id + '"> Edit Date from here </a>'
                })
            } else {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/hr/public/changeStatus',
                    data: {'is_active': is_active, 'id': id},
                    success: function (data) {
                        console.log(data.success)
                    }
                });
            }
        })
    })
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });

</script>
<script>
    $(document).ready(function ($) {
        $('form').on('submit', function (evt) {
            $('button[type=submit]').hide();
        });
    });
</script>
<?php /**PATH E:\pacra-hrms\resources\views/layout/partials/footer-scripts.blade.php ENDPATH**/ ?>