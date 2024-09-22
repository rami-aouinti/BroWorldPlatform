<template>
    <div>
        <v-btn
            :ripple="false"
            elevation="0"
            color="transparent"
            class="font-weight-bolder py-4 px-4 ms-auto"
            small
            @click="dialog = true"
        >
            <v-icon class="me-1" size="12">fa fa-edit</v-icon>
        </v-btn>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">Edit Hobby</v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field
                            v-model="editedHobby.name"
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
                    <v-btn color="red darken-1" text @click="dialog = false">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="submitEdit">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import ResumeService from "../../../../../services/resume.service";

export default {
    name: "EditHobby",
    props: {
        hobby: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            dialog: false,
            editedHobby: { ...this.hobby },
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
    methods: {
        async submitEdit() {
            const payload = {
                name: this.editedHobby.name,
                icon: this.selectedIcon.icon
            };
            try {
                const response = await ResumeService.updateHobby(this.editedHobby.id ,payload);
                this.$swal("Success", "Hobby has been updated successfully!", "success");
                this.$emit("hobby-updated", this.editedHobby);
                this.dialog = false;
            } catch (error) {
                this.$swal("Error", "An error occurred while saving the hobby.", "error");
                console.error(error);
            }
        },
    },
};
</script>
