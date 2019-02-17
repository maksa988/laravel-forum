<template>
    <div class="alert alert-flash"
         :class="`alert-${level}`"
         v-show="show"
         v-text="body"></div>
</template>

<script>
    export default {
        props: ['message'],

        data: function () {
            return {
                body: '',
                level: 'success',
                show: false,
            }
        },

        created() {
            if (this.message) {
                this.flash({
                    message: this.message,
                    level: 'danger',
                });
            }

            window.events.$on('flash', data => {
                this.flash(data);
            })
        },

        methods: {
            flash(data) {
                this.body = data.message;
                this.level = data.level;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>