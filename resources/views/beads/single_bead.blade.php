@extends('app')

@section('content')



    <h1>{{$bead->name_description}} </h1>

    <img src={{asset($bead->image())}}>
    <H3>{{ $bead->name }}</H3>

    @foreach($bead->finishes as $finish)
        {{$finish->name}}
    @endforeach


    @if(Auth::check())
        <div class="form-group">
            {!! Form::open(array('route' => 'favorites.addFavorites')) !!}
            {!! Form::hidden('bead_id', $bead->id) !!}
            {!! Form::submit('Add to favorites', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    @else
        <a href="{{ URL::route('login') }}" class="btn btn-info btn-block">Login</a>
    @endif

@stop