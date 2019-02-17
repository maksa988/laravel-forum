<template>
    <div>
        <div class="d-flex align-items-end">
            <img :src="avatar" width="50" height="50" class="mr-2 rounded ">

            <h1>
                {{ user.name }}

                <small v-text="reputation"></small>
            </h1>
        </div>

        <div class="py-3">
            <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile" aria-describedby="inputGroupFileAddon" accept="image/*" @change="onChange">
                        <label class="custom-file-label" for="inputGroupFile">Choose avatar</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon">Add avatar</button>
                    </div>
                </div>
            </form>
        </div>


    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                avatar: this.user.avatar_path,
            }
        },

        props: ['user'],

        computed: {
            canUpdate() {
                return this.authorize(user => user.id == this.user.id);
            },

            reputation() {
                return this.user.reputation + ' XP';
            }
        },

        methods: {
            onChange(e) {
                if (! e.target.files.length) return;

                let avatar = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(avatar);

                reader.onload = e => {
                    this.avatar = e.target.result;
                };

                //
                this.persist(avatar);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => { flash('Avatar uploaded!'); });
            }
        }
    }
</script>