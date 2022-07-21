<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
   /* $(document).on("click", ".openEditModel", function () {
        var editEventId = $(this).data('id');
        $('#editIdHolder').html( editEventId );
    });*/

   $(document).on("click", ".openEditModel", function () {
       var editEventId = $(this).data('todo').id;
       var editEventData = $(this).data('todo').todo;

       /*alert(editEventId);
       alert(editEventData);*/
       //$('#editIdHolder').html( editEventId );
       $('#editDataHolder').val( editEventData );
       $('#editIdHolder').val(editEventId);
       //document.getElementById('editIdHoldervalue').value=editEventId;
   });


</script>