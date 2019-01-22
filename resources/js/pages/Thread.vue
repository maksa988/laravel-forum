<script>
    import Replies from '../components/Replies.vue';

    export default {
        props: ['initialRepliesCount'],

        components: { Replies },

        data: function () {
            return {
                repliesCount: this.initialRepliesCount
                ,
            }
        }
    }
</script>