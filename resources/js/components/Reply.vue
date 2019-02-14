<template>
    <div>
        <div :id="`reply-${id}`" class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <a :href="`/profiles/${reply.owner.name}`" v-text="reply.owner.name"></a>
                        said <span v-text="ago"></span>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                        <div v-if="signedIn">
                            <favorite :reply="reply"></favorite>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-body" :class="isBest ? 'text-white bg-success' : ''">
                <div v-if="editing">
                    <form @submit.prevent="update">
                        <div class="form-group">
                            <wysiwyg v-model="body"></wysiwyg>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                    </form>
                </div>

                <div v-else v-html="body"></div>
            </div>

            <div class="card-footer d-flex flex-wrap" v-if="authorize('owns', reply)">
                <button class="btn btn-secondary mr-2 btn-sm" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
                <button class="btn btn-success btn-sm ml-auto" @click="markBestReply" v-show="! isBest">Best reply?</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

        data: function () {
            return {
                id: this.reply.id,
                editing: false,
                body: this.reply.body,
                thread: window.thread,
            }
        },

        computed: {
            isBest() {
                return this.thread.best_reply_id == this.id;
            },

            ago() {
                return moment(this.reply.created_at).fromNow() + '...';
            },
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + "/best");

                this.thread.best_reply_id = this.id;
            }
        }
    }
</script>