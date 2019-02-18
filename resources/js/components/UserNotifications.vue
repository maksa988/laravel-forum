<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="fas fa-bell"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"
               :href="notification.data.link"
               v-for="notification in notifications"
               v-text="notification.data.message"
               @click="markAsRead(notification)"
               :key="notification.id"
            ></a>
        </div>
    </li>
</template>

<script>
    export default {
        data: function () {
            return {
                notifications: false,
            };
        },

        computed: {
            endpoint() {
                return `/profiles/${window.App.user.username}/notifications`;
            }
        },

        created() {
            this.fetchNotifications();
        },

        methods: {
            fetchNotifications() {
                axios.get(this.endpoint)
                    .then(response => this.notifications = response.data);
            },
            markAsRead(notification) {
                axios.delete(`${this.endpoint}/${notification.id}`)
                    .then(({data}) => {
                        this.fetchNotifications();
                        document.location.replace(data.link);
                    });
            }
        }
    }
</script>