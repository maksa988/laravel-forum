<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['attributes'],

        components: { Favorite },

        mounted() {
            this.reply = JSON.parse(this.attributes);
            this.body = this.reply.body;
        },

        data: function () {
            return {
                reply: {
                    id: 0,
                    body: '',
                },
                editing: false,
                body: '',
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.reply.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.reply.id);

                $(this.$el).fadeOut(300, () => {

                    flash('Your reply has been deleted.');
                });
            }
        }
    }
</script>