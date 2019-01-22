<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['initialRepliesCount'],

        components: { Replies, SubscribeButton },

        data: function () {
            return {
                repliesCount: this.initialRepliesCount
                ,
            }
        }
    }
</script>