<template>
  <v-container fluid class="py-6">
    <v-row>
      <v-col lg="4" sm="8">
        <v-tabs background-color="transparent" class="text-left">
          <v-tabs-slider></v-tabs-slider>

          <v-tab :ripple="false" href="#tab-1">
            <span class="ms-1">Messages</span>
          </v-tab>

          <v-tab :ripple="false" href="#tab-2">
            <span class="ms-1">Social</span>
          </v-tab>

          <v-tab :ripple="false" href="#tab-3">
            <span class="ms-1">Notifications</span>
          </v-tab>

          <v-tab :ripple="false" href="#tab-4">
            <span class="ms-1">Backup</span>
          </v-tab>
        </v-tabs>
      </v-col>
    </v-row>
    <v-row class="px-4">
      <v-col lg="3">
        <v-card class="card-shadow border-radius-xl position-sticky top-1">
          <div class="px-4 pt-3 pb-0">
            <v-list>
              <v-list-item-group class="border-radius-sm">
                <v-list-item
                  class="px-3 py-1 border-radius-lg mb-2"
                  v-for="item in menu"
                  :key="item.icon"
                >
                  <v-icon
                    size="18"
                    class="material-icons-round me-2 text-dark"
                    >{{ item.icon }}</v-icon
                  >
                  <v-list-item-content class="py-0">
                    <a href="#profile" class="text-decoration-none">
                      <div class="d-flex flex-column">
                        <span class="text-dark text-sm">{{ item.text }}</span>
                      </div>
                    </a>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </div>
        </v-card>
      </v-col>
      <v-col lg="9">
        <v-card class="card-shadow px-4 py-4 overflow-hidden border-radius-xl">
          <v-row>
            <v-col cols="auto">
                <dropzone class="my-dropzone" v-model="fileSingle"></dropzone>
            </v-col>
            <v-col cols="auto" class="my-auto">
              <div v-if="this.user && this.profile" class="h-100">
                <h5 class="mb-1 text-h5 text-typo font-weight-bold">
                    {{ this.user.firstName }} {{ this.user.lastName }}
                </h5>
                <p class="mb-0 font-weight-light text-body text-sm">
                    {{ this.profile.title }}
                </p>
              </div>
            </v-col>
            <v-col
              lg="4"
              md="6"
              class="my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3"
            >
              <div class="d-flex align-center">
                <p
                  class="mb-0 text-body text-xs ms-auto"
                  v-if="switche === true"
                >
                  Switch to invisible
                </p>
                <p
                  class="mb-0 text-body text-xs ms-auto"
                  v-if="switche === false"
                >
                  Switch to visible
                </p>
                <v-switch
                  :ripple="false"
                  class="mt-0 pt-0 ms-3 switch"
                  v-model="switche"
                  hide-details
                ></v-switch>
              </div>
            </v-col>
          </v-row>
        </v-card>
        <basic-info></basic-info>
        <change-password></change-password>
        <two-factor></two-factor>
        <accounts></accounts>
        <notifications></notifications>
        <sessions></sessions>
        <delete-account></delete-account>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import BasicInfo from "./Widgets/BasicInfo.vue";
import ChangePassword from "./Widgets/ChangePassword.vue";
import TwoFactor from "./Widgets/TwoFactor.vue";
import Accounts from "./Widgets/Accounts.vue";
import Notifications from "./Widgets/Notifications.vue";
import Sessions from "./Widgets/Sessions.vue";
import DeleteAccount from "./Widgets/DeleteAccount.vue";
import {mapGetters} from "vuex";
import Dropzone from "../../Ecommerce/Products/Widgets/Dropzone.vue";

export default {
  name: "Setting",
  components: {
      Dropzone,
    BasicInfo,
    ChangePassword,
    TwoFactor,
    Accounts,
    Notifications,
    Sessions,
    DeleteAccount,
  },
  data() {
    return {
      switche: true,
      menu: [
        {
          icon: "person",
          text: "Profile",
        },
        {
          icon: "receipt_long",
          text: "Basic Info",
        },
        {
          icon: "lock",
          text: "Change Password",
        },
        {
          icon: "security",
          text: "2FA",
        },
        {
          icon: "badge",
          text: "Accounts",
        },
        {
          icon: "campaign",
          text: "Notifications",
        },
        {
          icon: "settings_applications",
          text: "Sessions",
        },
        {
          icon: "delete",
          text: "Delete Account",
        },
      ],
        fileSingle: [],
    };
  },
    computed: {
        ...mapGetters('profile', ['profile']),
        ...mapGetters('user', ['user']),
    },
    watch: {
        user: {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.user.firstName = newValue.firstName || '';
                    this.user.lastName = newValue.lastName || '';
                    this.user.email = newValue.email || '';
                }
            }
        },
        profile: {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.profile.gender = newValue.gender || 'Male';
                    this.profile.title = newValue.title || '';
                    this.profile.birthMonth = newValue.birthMonth || 'February';
                    this.profile.birthDay = newValue.birthDay || '1';
                    this.profile.birthYear = newValue.birthYear || '2021';
                    this.profile.location = newValue.location || '';
                    this.profile.phoneNumber = newValue.phoneNumber || '';
                    this.profile.language = newValue.language || 'English';
                    this.profile.skills = newValue.skills || [];
                }
            }
        }
    },
    methods: {
        getInitials(string) {
            var names = string.split(" "),
                initials = names[0].substring(0, 1).toUpperCase();

            if (names.length > 1) {
                initials += names[names.length - 1].substring(0, 1).toUpperCase();
            }
            return initials;
        }
    }
};
</script>
<style scoped>
.my-dropzone {
    width: 100%;    /* Par exemple, pour prendre toute la largeur du conteneur parent */
    max-width: 100px; /* Largeur maximale */
    height: 100px;  /* Hauteur spécifique */
    border: 3px solid #000000; /* Bordure solide pour la zone de drop */
    border-radius: 50%; /* Bordures arrondies */
    background: #e9ecef; /* Couleur de fond */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden; /* Cache le contenu qui dépasse les bordures */
}
</style>
