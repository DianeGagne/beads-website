<template>
    <div class="modal fade" id="registerModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sign in/Register</h4>
                </div>
                <div class="modal-body">
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
                            <input id="login-username" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Email">
                            <input id="login-password" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Password">
                        </div>
                        <div class="tab-pane login-tab" id="register">
                            Register
                            <input id="name" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Name">
                            <input id="username" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Email">
                            <input id="password" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Password">
                            <input id="password-again" type="text" style="min-width:500px; max-width:100%;"
                                   placeholder="Confirm Password">
                        </div>
                        <div class="tab-pane login-tab" id="guest">
                            Continue as guest
                        </div>
                    </div>
                    @endif

                    <div class="modal-footer">
                        <button class="btn btn-primary">Sign-in</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
        },

        methods: {
        },
    }
</script>
