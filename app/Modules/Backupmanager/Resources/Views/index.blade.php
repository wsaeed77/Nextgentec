@extends('admin.main')
@section('content')
@section('content_header')
<h1>
 Nexpbx
</h1>
<ol class="breadcrumb">
  <li>
    <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Nexpbx
  </li>
  <li class="active">
    <i class="fa fa-table"></i> Attach Domain
  </li>
</ol>
@endsection
<section class="content">
  <table id="scripts" class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Language</th>
        <th>Title</th>
        <th>Active</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($scripts as $script)
      <tr data-id="{{ $script->id }}">
        <td>{{ $script->id }}</td>
        <td>{{ $script->script_language }}</td>
        <td>{{ $script->title }}</td>
        <td>{{ $script->active }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
{{Uuid::generate()}}
</section>

@endsection
@section('styles')
<link rel="stylesheet" href="/DataTables/datatables.min.css">
<style>

</style>
@endsection


@section('script')
@parent
<script type="text/javascript">


$('#scripts tr').click(function() {
  var url = '{{ URL::route('admin.backupmanager.editor', ['id' => ':id']) }}';
  url = url.replace(':id', $(this).data("id"));
  window.open(url, 'ScriptEditor');
});

</script>
@endsection
