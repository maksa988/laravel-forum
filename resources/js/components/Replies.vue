<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <div class="mt-3">
            <new-reply :endpoint="endpoint" @created="add"></new-reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';

    export default {
        props: ['data'],

        components: { Reply, NewReply },

        data: function () {
            return {
                items: this.data,
                endpoint: location.pathname + '/replies',
            }
        },

        methods: {
            add(reply) {
                this.items.push(reply);

                this.$emit('added');
            },

            remove(index) {
                this.items.splice(index, 1);

                this.$emit('removed');

                flash('Your reply has been deleted.');
            }
        }
    }
</script>