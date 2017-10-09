<template>
    <div class="container">
        <div id="register">
            <form class="form-horizontal" id="signin-form">
                <fieldset>
                    <!-- Sign In Form -->
                    <!-- Text input-->
                    <div class="control-group">
                        <label class="control-label" for="userid">Alias:</label>
                        <div class="controls">
                            <input id="userid" name="userid" type="text" class="form-control"
                                   placeholder="JoeSixpack" required="">
                        </div>
                    </div>

                    <!-- Password input-->
                    <div class="control-group">
                        <label class="control-label" for="passwordinput">Password:</label>
                        <div class="controls">
                            <input id="passwordinput" name="passwordinput" class="form-control"
                                   type="password" placeholder="********">
                        </div>
                    </div>

                    <!-- Multiple Checkboxes (inline) -->
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox inline" for="rememberme-0">
                                <input type="checkbox" name="rememberme" id="rememberme-0"
                                       value="Remember me">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="control-group">
                        <div class="controls">
                            <button id="signin-button" name="signin" class="btn btn-success"
                                    v-on:click.prevent="onSubmit">Sign In
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</template>
<script>

    export default {

        computed: {
            form_method: function () {
                return this.$el.method.toLowerCase();
            },
            form_action: function () {
                return this.$el.action.toLowerCase();
            },
        },

        methods: {
            onSubmit: function (event) {
                var formData = new FormData(this.$el);

                this.$http[this.form_method](this.form_action, formData)
                    .then(this.successCallBack, this.errorCallBack);
            },

            successCallBack: function (response) {
                console.log('AjaxForm submission: SUCCESS');
            },

            errorCallBack: function (response) {
                console.log('AjaxForm submission: ERROR');
            },
        },
    }
</script>
