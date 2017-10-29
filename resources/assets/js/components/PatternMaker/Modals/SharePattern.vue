<template>
    <div id="share-pattern">
        <button @click="sharePattern" class="btn-primary">Share</button>
        <modal name="share-pattern">
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
                        <input type="text" style="min-width:500px; max-width:100%;"
                               placeholder="Email">
                        <input type="text" style="min-width:500px; max-width:100%;"
                               placeholder="Password">
                    </div>
                    <div class="tab-pane login-tab" id="register">
                        Register
                        <input id="name" type="text" style="min-width:500px; max-width:100%;" placeholder="Name">
                        <input id="username" type="text" style="min-width:500px; max-width:100%;"
                               placeholder="Email">
                        <input id="password" type="text" style="min-width:500px; max-width:100%;"
                               placeholder="Password">
                        <input id="password_confirm" type="text" style="min-width:500px; max-width:100%;"
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
        </modal>
    </div>
</template>
<script>
    export default {
        data: function () {
        },
        created: function () {
        },
        mounted() {
        },
        methods: {
            methods: {
                sharePattern: function () {
                    this.$modal.show('share-pattern');
                }
            }
        }
    }
</script>
