<template>
    <div>
        <div v-if="signedIn">
            <div class="from-group mb-3">
                <textarea name="body" class="form-control" placeholder="Have something to say?" rows="5" required v-model="body"></textarea>
            </div>

            <button type="submit" class="btn btn-success" @click="addReply">Post</button>
        </div>

        <div v-else>
            <p class="text-center mt-3">Please <a href="/login">sign in</a> to participate in this discussion.</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data: function () {
            return {
                body: ''
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', data)
                    });
            }
        }

    }
</script>