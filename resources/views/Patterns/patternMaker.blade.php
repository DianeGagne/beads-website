@extends('layouts.app')
@section('navbar-options')
    <a id="clear" class="navbar-brand" data-toggle="modal" data-target="#newPattern">Create New</a>
    <a id="save" class="navbar-brand" data-toggle="modal" data-target="#sharePattern">Share</a>
    @stop
@section('content')
    <div style="display:flex; padding: 5px 5px 5px 15px;">

        <input id="Name" name="name" type="text" style="min-width:500px; max-width:100%;" placeholder="Pattern Name">
    </div>

    <PatternMaker></PatternMaker>

    <div class="modal fade" id="sharePattern" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Share your pattern</h4>
                </div>
                <div class="modal-body">

                    <label>Pattern Name</label>
                    <input id="share-name" type="text" style="min-width:500px; max-width:100%;"
                           placeholder="Pattern Name">


                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                            <li><a href="#register" data-toggle="tab">Register</a></li>
                            <li><a href="#guest" data-toggle="tab">Guest</a></li>
                        </ul>
                    </div>

                    @if (Auth::guest())
                    <div class="tab-content">
                        <div class="tab-pane active login-tab" id="login">
                            Login to get credit for your creation
                            <input id="username" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Email">
                            <input id="password" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Password">
                        </div>
                        <div class="tab-pane login-tab" id="register">
                            Register
                            <input id="name" type="text" style="min-width:500px; max-width:100%;" placeholder="Name">
                            <input id="username" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Email">
                            <input id="password" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Password">
                            <input id="password" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Confirm Password">
                        </div>
                        <div class="tab-pane login-tab" id="guest">
                            Continue as guest
                        </div>
                    </div>
                    @endif

                    Type: Delica
                    <div class="size-descriptions">
                        2x25 cm
                        196 beads (8g)
                    </div>

                    <div class="modal-footer">
                        <button>See Pattern</button>
                        <button>Pintrest</button>
                        <button>Link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

