<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value">

        <trix-editor
                ref="trix"
                input="trix"
                @trix-change="change"
                :placeholder="placeholder">
        </trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';

    Trix.config.blockAttributes.default.tagName = "p"
    Trix.config.blockAttributes.code.tagName = "code";

    export default {
        props: ['name', 'value', 'placeholder'],

        watch: {
            value(val) {
                if (val === '') {
                    this.$refs.trix.value = '';
                }
            }
        },

        methods: {
            change({target}) {
                this.$emit('input', target.value)
            }
        }
    }
</script>