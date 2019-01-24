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

        created() {
            axios.get(`/profiles/${window.App.user.name}/notifications`)
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete(`/profiles/${window.App.user.name}/notifications/${notification.id}`);
            }
        }
    }
</script>