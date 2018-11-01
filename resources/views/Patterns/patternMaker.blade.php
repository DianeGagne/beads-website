@extends('layouts.app')
@section('navbar-options')
@stop
@section('content')

    <div id="patternMaker" style="height:87vh;">
        <div style="display: flex; height:100%;">
            <div id="pattern" style="height:100%; width:100%;">
                <pattern-canvas></pattern-canvas>
            </div>
            <div id="controls" style="height:100%; right:0">
                <action-bar></action-bar>
            </div>
        </div>
    </div>
@stop

