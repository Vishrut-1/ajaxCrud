<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<style>
#qwe{

 margin-bottom:20px;

}
</style>
<div class="container">
    <h2><center>Laravel Services Table </center></h2>
   <div id="qwe"> <a class="btn btn-success" href="javascript:void(0)" id="createNewService"> Add New Service</a></div>
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="serviceForm" name="serviceForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="service_id" id="service_id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <textarea id="email" name="email" required="" placeholder="Enter email" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript">

    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({

            processing: true,
            serverSide: true,
            ajax: "{{ route('ajaxservices.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
;
        $('#createNewService').click (function () {

            $('#saveBtn').val("create-service");
            $('#service_id').val("id");
            $('#serviceForm').trigger("reset");
            $('#modelHeading').html("Create New Service");
            $('#ajaxModel').modal('show');

        });

        //Edit Services

        $('body').on('click', '.editService', function (){

                var service_id = $(this).data("id");

                $.get("{{ route('ajaxservices.index') }}"+'/'+service_id+'/edit',function(data) {

                $('#modelHeading').html("Edit Service");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#service_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);

            });
        });

        //Insert data

        $('#saveBtn').click(function(e) {

            e.preventDefault();
            //$(this).html('Sending..');
            $.ajax({

                data: $('#serviceForm').serialize(),
                url: "{{ route('ajaxservices.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#serviceForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            })
        });

        //Delete Services

        $('body').on('click', '.deleteService', function() {

            var service_id = $(this).data("id");

            alert('Delete The Service');

            $.ajax({
                type: "DELETE",
                url: "{{ route('ajaxservices.store') }}"+'/'+service_id,
                success: function (data) {
                    table.draw();

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });
</script>
</html>
