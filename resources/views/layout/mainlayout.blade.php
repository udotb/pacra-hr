<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

@include('layout.partials.nav')

@include('layout.partials.header')

@yield('content')
@include('layout.partials.footer-scripts')


</body>
</html>
<script>

    $(document).ready(function () {

        $('select#type').on('change', function () {
            if (this.value === '5') {
                $("#fileproof").show();
            } else $("#fileproof").hide();
        });

        $('select.reimbursementType').on('change', function () {
            if (this.value === '1' || this.value === '5') {
                $("div#clientDiv").hide();
                $("div#kmsDiv").hide();
                $("div#otherClientDiv").hide();
                $("div#otherAmountDiv").show();
                $("select#clientSelect").removeAttr('required');
                $("select#clientSelect").removeAttr('name');
                $("input#kmsInput").removeAttr('name');
                $("input#kmsInput").removeAttr('required');
                $("input#otherClientInput").removeAttr('required');
                $("input#otherClientInput").removeAttr('name');
            } else {
                $("div#clientDiv").show();
                $("div#otherAmountDiv").hide();
                $("input#otherAmountInput").removeAttr('required');
                $("input#otherAmountInput").removeAttr('name');

            }
        });
        $('select.reimbursementType').on('change', function () {
            if (this.value === '2') {
                $("div#travelType").show();
                $("div#medicalTypeDiv").hide();
                $("select#medicalTypeInput").removeAttr('required');
                $("select#medicalTypeInput").removeAttr('name');
            } else if (this.value === '1') {
                $("div#medicalTypeDiv").show();
                $("div#travelType").hide();
                $("select#tt2").removeAttr('required');
                $("#amountInput").removeAttr('required');
                $("#amountInput").removeAttr('name');
            } else {
                $("div#travelType").hide();
                $("div#medicalTypeDiv").hide();
                $("select#tt2").removeAttr('required');
                $("#amountInput").removeAttr('required');
                $("#amountInput").removeAttr('name');
                $("select#medicalTypeInput").removeAttr('required');
                $("select#medicalTypeInput").removeAttr('name');
            }
        });

        $('select#tt2').on('change', function () {
            if (this.value === '1' || this.value === '2' || this.value === '3') {
                $("div#amountDiv").show();
                $("div#kmsDiv").hide();
                $("#kmsInput").removeAttr('required');
                $("#kmsInput").removeAttr('name');
            } else if (this.value === '4') {
                $("div#kmsDiv").show();
                $("div#amountDiv").hide();
                $("#amountInput").removeAttr('required');
                $("#amountInput").removeAttr('name');

            } else {
                $("div#amountDiv").hide();
                $("div#kmsDiv").hide();
                $("#amountInput").removeAttr('required');
                $("#amountInput").removeAttr('name');
                $("#kmsInput").removeAttr('required');
                $("#kmsInput").removeAttr('name');
            }
        });
        $('select#clientSelect').on('change', function () {
            if (this.value === 'other') {
                // $("div#clientDiv").hide();
                $("div#otherClientDiv").show();
                $("div#otherClientInput").removeAttr('required');
            } else if (this.value !== 'other') {
                $("div#otherClientDiv").hide();
                $("div#clientDiv").show();
            } else {
                $("div#otherClientDiv").hide();
            }
        });

        $('select#interviewRound').on('change', function () {
            if (this.value === 'HR/TL') {
                $("div#HRTL").show();
                $("div#UH").hide();
                $("div#CEO").hide();
            } else if (this.value === 'Vertical Chief') {
                $("div#UH").show();
                $("div#HRTL").hide();
                $("div#CEO").hide();
            } else if (this.value === 'CEO/Final') {
                $("div#CEO").show();
                $("div#UH").hide();
                $("div#HRTL").hide();
            } else {
                $("div#CEO").hide();
                $("div#UH").hide();
                $("div#HRTL").hide();
            }
        });

        $('select#designation').on('change', function () {
            if (this.value === '29') {
                $("div#internshipTenureDiv").show();
                $("div#gradDateDiv").show();
            } else {
                $("div#internshipTenureDiv").hide();
                $("div#stipendDiv").hide();
                $("div#gradDateDiv").hide();
            }
        });
        $('select#internshipTenure').on('change', function () {
            if (this.value === '2 Weeks') {
                $("input#stipend1").show();
                $("input#stipend2").hide();
                $("div#stipendDiv").show();
                $("input#stipend2").removeAttr('name');
            } else if (this.value !== '2 Weeks') {
                $("input#stipend1").hide();
                $("input#stipend2").show();
                $("div#stipendDiv").show();
                $("input#stipend1").removeAttr('name');
            } else {
                $("input#stipend1").hide();
                $("input#stipend2").hide();
                $("div#stipendDiv").hide();
                $("input#stipend1").removeAttr('name');
                $("input#stipend2").removeAttr('name');
            }
        });

        if ($('select#designation').val() === '29') {
            $("div#internshipTenureDiv").show();
            $("div#gradDateDiv").show();
            $("div#stipendDiv").show();
            $("input#stipend1").show();
        }

        // if ($('select#internshipTenure').val() === '2 Weeks') {
        //     $("input#stipend1").show();
        // } else {
        //     $("input#stipend2").show();
        // }
    });

    $("#udu").fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000).fadeOut(1000).fadeIn(1000);

</script>
<script>
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>


{{--<script>--}}
{{--    var options = $('select option#sort');--}}
{{--    var arr = options.map(function (_, o) {--}}
{{--        return {--}}
{{--            t: $(o).text(),--}}
{{--            v: o.value--}}
{{--        };--}}
{{--    }).get();--}}
{{--    arr.sort(function (o1, o2) {--}}
{{--        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;--}}
{{--    });--}}
{{--    options.each(function (i, o) {--}}
{{--        console.log(i);--}}
{{--        o.value = arr[i].v;--}}
{{--        $(o).text(arr[i].t);--}}
{{--    });--}}
{{--</script>--}}
{{--<script>--}}
{{--    $('form').bind('submit', function (e) {--}}
{{--        var button = $('button');--}}
{{--        button.prop('disabled', true);--}}
{{--        var valid = true;--}}
{{--        if (!valid) {--}}
{{--            e.preventDefault();--}}
{{--            button.prop('disabled', false);--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
{{--<script>--}}
{{--    $('form').submit(function () {--}}
{{--        $('button[type=submit]').addClass("disabled");--}}
{{--    });--}}
{{--</script>--}}

<script>
    $(document).ready(function ($) {
        $('form').on('submit', function (evt) {
            $('button[type=submit]').hide();
        });
    });
</script>

{{--<script>--}}
{{--    $('.summernote').summernote({--}}
{{--        callbacks: {--}}
{{--            onPaste: function (e) {--}}
{{--                alert('dd');--}}
{{--                // var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');--}}
{{--                // console.log(bufferText);--}}
{{--                // e.preventDefault();--}}
{{--                // var div = $('<div />');--}}
{{--                // div.append(bufferText);--}}
{{--                div.find('*').removeAttr('style');--}}
{{--                setTimeout(function () {--}}
{{--                    document.execCommand('insertHtml', false, div.html());--}}
{{--                }, 10);--}}
{{--            }--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
