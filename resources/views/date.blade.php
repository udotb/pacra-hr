@extends('layout.mainlayout')
@section('content')


    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/multidate.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    </head>

<body>
<div class="container">
    <h3>Bootstrap Multi Select Date Picker</h3>
    <input type="text" class="form-control date" value="20-11-2020, 21-11-2020" placeholder="Pick the multiple dates">
</div>
<script>


    dp = $('.date').datepicker({
        format: "dd-mm-yyyy",
        multidate: true,
        inline: true,
        todayHighlight: false,
        daysOfWeekDisabled: [0],
        startDate: 'today'
    });
    dp.on('changeDate', function(e) {

        if(e.dates.length <4){
            selectedDates = e.dates
        }else{
            dp.data('datepicker').setDates(selectedDates);
            alert('Can only select 3 dates')
        }

    });



</script>
@endsection