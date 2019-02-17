<template>
    <div>
        <div v-if="! signedIn">
            <p class="text-center mt-3">Please <a href="/login">sign in</a> to participate in this discussion.</p>
        </div>

        <div v-else-if="! confirmed">
            <p class="text-center mt-3">To participate in this thread, please check your email and confirm your account.</p>
        </div>

        <div v-else>
            <div class="from-group mb-3">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?"></wysiwyg>
            </div>

            <button type="submit" class="btn btn-success" @click="addReply">Post</button>
        </div>
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        data: function () {
            return {
                body: '',
            }
        },

        mounted() {
            $("#body").atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        $.getJSON('/api/users', {name: query}, function (usernames) {
                            callback(usernames);
                        });
                    }
                }
            })
        },

        computed: {
            confirmed() {
                return window.App.user.confirmed;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .catch(error => {
                            flash(error.response.data, "danger");
                        })
                    .then(({ data }) => {
                        this.body = '';

                        flash("Your reply has been posted.");

                        this.$emit("created", data);
                    });
            }
        }

    }
</script>