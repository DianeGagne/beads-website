@extends('layouts.app')
@section('content')
    <div style="display:flex; padding: 5px 5px 5px 15px;">
        <button id="clear" class="btn btn-primary" data-toggle="modal" data-target="#newPattern">Create New</button>
        <button id="save" class="btn btn-primary" data-toggle="modal" data-target="#sharePattern">Share</button>
        <input id="Name" name="name" type="text" style="min-width:500px; max-width:100%;" placeholder="Pattern Name">
    </div>

    <PatternMaker></PatternMaker>

    <div class="modal fade" id="newPattern" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Pattern</h4>
                </div>
                <div class="modal-body">
                    <label>Pattern Name</label>
                    <input id="new-name" type="text" style="min-width:500px; max-width:100%;"
                           placeholder="Pattern Name">
                    <hr>
                    <div class="bead-type">
                        <div class="radio">
                            <label><input type="radio" id="delica" value="delica" v-model="beadType">Delica</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" id="round" value="round" v-model="beadType">Round (Czech)</label>
                        </div>
                    </div>
                    <grid-size :gridWidth.sync="gridWidth" :gridHeight.sync="gridHeight"></grid-size>

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li><a href="#background-image" data-toggle="tab">From Image</a></li>
                            <li><a href="#background-bead" data-toggle="tab">Background Bead</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane login-tab" id="background-image">
                            <input type="file">
                        </div>
                        <div class="tab-pane login-tab" id="background-bead">
                            <color-section></color-section>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

