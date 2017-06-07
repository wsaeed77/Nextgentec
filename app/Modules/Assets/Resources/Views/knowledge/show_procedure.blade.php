@extends('admin.minimal.main')
@section('title', $procedure->title)
@section('content')

<div class="page-header">
  <h1>{{$procedure->title}}</h1>
  @if(isset($procedure->customer->name))
  <p class="lead">{{$procedure->customer->name}}</p>
  @else
  <p class="lead"><i>Unassigned</i></p>
  @endif
</div>

<div class="well well-lg procedure-html">
{!! html_entity_decode($procedure->procedure) !!}
</div>

@endsection

@section('styles')
@parent
<style>
div.procedure-html ol li {
  margin: 0 0 5px 0;
  padding-left: 3px;
}
div.procedure-html img {
  padding: 15px 8px 15px 0;
}
</style>

@endsection
