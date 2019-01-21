<template>
    <button :class="classes" @click="toggle">
        <span class="fas fa-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data: function () {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
            }
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-secondary',
                    'btn-sm'
                ];
            },

            endpoint() {
                return '/replies/'+ this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                return this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            },

            destroy() {

                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
            }
        }
    }
</script>