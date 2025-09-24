
@extends('layout')
@section('content')


  <ul class="list-group">
    @foreach($errors->all() as $error)
       <li class="list-group-item list-group-item-danger">      
           {{$error}}
       </li> 
     @endforeach 
    </ul>

<form action="/article" method="POST">
    @CSRF
  <div class="mb-3">
    <label for="Date" class="form-label">Date public</label>
    <input type="date" class="form-control" id="date"  name="date">
  </div>
<div class="mb-3">
    <label for="title" class="form-label">Enter title</label>
    <input type="text" class="form-control" id="title" name="title">
  </div>
  <div class="mb-3">
    <label for="text" class="form-label">Enter description</label>
    <textarea type="text" class="form-control" id="exampleInputPassword1"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Save article</button>
</form>

@endsection