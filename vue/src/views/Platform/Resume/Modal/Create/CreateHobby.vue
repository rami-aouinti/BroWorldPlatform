<template>
    <v-row>
        <v-btn
            :ripple="false"
            elevation="0"
            color="#fff"
            class="font-weight-bolder btn-outline-primary py-4 px-4 ms-auto"
            small
            @click="dialog = true"
        >
            <v-icon class="me-1" size="12">fa fa-plus</v-icon>
        </v-btn>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">
                    New Hobby
                </v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="name"
                            label="Hobby Name"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-select
                            v-model="selectedIcon"
                            :items="icons"
                            label="Select an icon"
                            item-text="text"
                            item-value="icon"
                            return-object
                            outlined
                            dense
                            :append-icon="selectedIcon ? selectedIcon.icon : ''"
                        >
                            <template v-slot:selection="data">
                                <v-icon size="20" class="me-2 material-icons-round" left>{{ data.item.icon }}</v-icon>
                                {{ data.item.text }}
                            </template>
                            <template v-slot:item="data">
                                <v-icon size="20" class="me-2 material-icons-round" left>{{ data.item.icon }}</v-icon>
                                {{ data.item.text }}
                            </template>
                        </v-select>
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="dialog = false">
                        Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="submitForm">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import Vue from "vue";
import { mapGetters } from "vuex";
import VueSweetalert2 from "vue-sweetalert2";
import ResumeService from "../../../../../services/resume.service";

Vue.use(VueSweetalert2);

export default {
    name: "CreateHobby",
    data() {
        return {
            dialog: false,
            valid: false,
            name: null,
            selectedIcon: null,
            icons: [
                { text: 'Home', icon: 'home' },
                { text: 'Person', icon: 'person' },
                { text: 'Settings', icon: 'settings' },
                { text: 'Email', icon: 'email' },
                { text: 'Notifications', icon: 'notifications' },
                { text: 'Camera', icon: 'camera_alt' },
                { text: 'Favorite', icon: 'favorite' },
                { text: 'Star', icon: 'star' },
                { text: 'Delete', icon: 'delete' },
                { text: 'Search', icon: 'search' },
                { text: 'Shopping Cart', icon: 'shopping_cart' },
                { text: 'Account Circle', icon: 'account_circle' },
                { text: 'Info', icon: 'info' },
                { text: 'Check Circle', icon: 'check_circle' },
                { text: 'Warning', icon: 'warning' },
                { text: 'Lock', icon: 'lock' },
                { text: 'Help', icon: 'help' },
                { text: 'Phone', icon: 'phone' },
                { text: 'Visibility', icon: 'visibility' },
                { text: 'Edit', icon: 'edit' },
                { text: 'Send', icon: 'send' },
                { text: 'Cloud', icon: 'cloud' },
                { text: 'Attach File', icon: 'attach_file' },
                { text: 'Map', icon: 'map' },
                { text: 'Build', icon: 'build' },
                { text: 'Print', icon: 'print' },
                { text: 'Exit to App', icon: 'exit_to_app' },
                { text: 'Arrow Back', icon: 'arrow_back' },
                { text: 'Arrow Forward', icon: 'arrow_forward' },
                { text: 'Thumb Up', icon: 'thumb_up' },
                { text: 'Thumb Down', icon: 'thumb_down' },
                { text: 'Add Circle', icon: 'add_circle' },
                { text: 'Remove Circle', icon: 'remove_circle' },
                { text: 'Share', icon: 'share' },
                { text: 'Favorite Border', icon: 'favorite_border' },
                { text: 'Event', icon: 'event' },
                { text: 'Visibility Off', icon: 'visibility_off' },
                { text: 'Battery Full', icon: 'battery_full' },
                { text: 'Wifi', icon: 'wifi' },
                { text: 'Bluetooth', icon: 'bluetooth' },
                { text: 'File Download', icon: 'file_download' },
                { text: 'Upload', icon: 'upload' },
                { text: 'Keyboard Arrow Down', icon: 'keyboard_arrow_down' },
                { text: 'Keyboard Arrow Up', icon: 'keyboard_arrow_up' },
                { text: 'Menu', icon: 'menu' },
                { text: 'More Vert', icon: 'more_vert' },
                { text: 'Check', icon: 'check' },
                { text: 'Close', icon: 'close' },
                { text: 'Alarm', icon: 'alarm' },
                { text: 'Face', icon: 'face' },
            ],
        };
    },
    computed: {
        ...mapGetters("user", ["user"]),
    },
    methods: {
        async submitForm() {
            if (!this.name) {
                this.$swal("Error", "Please fill out all required fields.", "error");
                return;
            }

            const payload = {
                name: this.name,
                icon: this.selectedIcon.icon
            };
            try {
                const response = await ResumeService.createHobby(payload);
                this.$swal("Success", "Hobby has been added successfully!", "success");
                this.dialog = false;
                this.resetForm();
                this.$emit('hobby-added', payload);
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the hobby.", "error");
                console.error(error);
            }
        },

        resetForm() {
            this.name = null;
            this.school = null;
            this.description = null;
            this.selectedLevel = null;
            this.startedAt = null;
            this.endedAt = null;
        }
    },
};
</script>
