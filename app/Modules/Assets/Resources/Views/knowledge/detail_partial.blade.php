<div style="margin-bottom: 15px;">
@foreach ($password->tags as $tag)
  <span class="label label-primary">{{$tag->title}}</span>
@endforeach
</div>

<div class="panel panel-default">
  <div class="panel-heading">Credentials</div>
  <table class="table">
    <tr>
      <td class="width35">Username</td>
      <td>{{$password->login}}</td>
    </tr>
    <tr>
      <td class="width35">Password</td>
      <td>{{$password->password}}</td>
    </tr>
  </table>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    Notes
  </div>
  <div class="panel-body">
    <pre>{{$password->notes}}</pre>
  </div>
</div>

<style>
.hideOverflow
{
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
    width:100%;
    display:block;
}

.width35 {
  width: 35%;
}
</style>
