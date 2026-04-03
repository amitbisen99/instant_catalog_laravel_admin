@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-xl-12">
        <h5 class="mb-3">Users</h5>
        <div class="card tbl-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Source</th  >
                                <th>Industry</th>
                                <th>Business Type</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}

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
        dom: '<"top" l f>rt<"bottom "ip><"clear">',
        ajax: {
            url:  "{{ route('users') }}",
            type: "get",
            data: function (d) {
                d.status = $('#statusFilter').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', "width": "10%"},
            {data: 'full_name', name : 'full_name', "width": "20%"},
            {data: 'mobile_number', name : 'mobile_number', "width": "20%"},
            {data: 'device_type', name : 'device_type', "width": "10%"},
            {data: 'industry_type', name : 'industry_type', "width": "10%"},
            {data: 'business_type', name : 'business_type', "width": "10%"},
            {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%"},
        ]
      });

      $("div.dataTables_filter").prepend(`
        <select class="form-control form-control-sm" id="statusFilter">
          <option value="sdknglnsdgksdjgjsdgjbsdbjs">All</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      `);

      $(document).on('change', '#statusFilter', function () {
        table.ajax.reload();
      });

      $('body').on('click', '.editPost', function () {
        var id = $(this).data('id');
        var status = $(this).data('status');

        Swal.fire({
            title: "Do you want to " + status + " ?",
            showDenyButton: true,
            confirmButtonText: "Change",
            denyButtonText: `Cancel`
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('user.status-change', ":id") }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "POST",
                    url:url,
                    data : { status : status },
                    success: function (data) {
                        if (data.status) {
                            Swal.fire("Status Changed!", "", "success");
                            table.draw();
                        }
                    },
                    error: function (data) {
                        Swal.fire("Something Went Warong!", "", "error");
                    }
                });
            }
        });
    });
      
    $('body').on('click', '.deletePost', function () {
        var id = $(this).data("id");

        Swal.fire({
            title: "Do you want to delete this user ?",
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: "Delete",
            denyButtonText: `Cancel`
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('user.delete', ":id") }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "POST",
                    url:url,
                    success: function (data) {
                        if (data.status) {
                            Swal.fire("Deleted!", "", "success");
                            table.draw();
                        }
                    },
                    error: function (data) {
                        Swal.fire("Something Went Warong!", "", "error");
                    }
                });
            }
        });
      });
    });
  </script>
@endsection