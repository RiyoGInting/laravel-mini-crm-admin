@extends('layouts.master')
@section('custom-head')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
@endsection

@section('title', 'Company List')

@section('custom-nav-li')
<li class="breadcrumb-item"><a href="/api/admin/logout">{{trans('multilingual.logout')}}</a></li>
@endsection

@section('content')
<div class="container mt-5">
    <form action="/companies/import" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" name="file">

            <button type="submit" class="btn btn-primary">{{trans('multilingual.import_excel')}}</button>
        </div>
    </form>

    <table class="table table-bordered table-striped companies" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>{{trans('multilingual.name')}}</th>
                <th>{{trans('multilingual.email')}}</th>
                <th>{{trans('multilingual.logo')}}</th>
                <th>{{trans('multilingual.website')}}</th>
                <th>{{trans('multilingual.created_at')}}</th>
                <th>{{trans('multilingual.created_by')}}</th>
                <th>{{trans('multilingual.updated_by')}}</th>
                <th>{{trans('multilingual.action')}}</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Logo</th>
                <th>Website</th>
                <th>Created At</th>
                <th>Created By</th>
                <th>Updated By</th>
            </tr>
        </tfoot>
    </table>
    <a href="/addCompanies" class="btn btn-primary">{{trans('multilingual.add')}}</a>
    <a href="/companies/export" class="btn btn-primary">{{trans('multilingual.download')}}</a>
</div>
@endsection

@section('datatable')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.companies').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('companies.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'logo',
                    name: 'logo'
                },
                {
                    data: 'website',
                    name: 'website'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'created_by_id',
                    name: 'created_by_id'
                },
                {
                    data: 'updated_by_id',
                    name: 'updated_by_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.placeholder = "type here & hit enter";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            },
            order: [
                [0, 'desc']
            ]
        });
    });
</script>
@endsection