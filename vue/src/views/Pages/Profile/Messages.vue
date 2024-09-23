<template>
  <v-container fluid class="py-6 px-0">
    <v-row>
      <v-col md="4">
        <v-card class="pt-8 px-3 shadow-blur">
          <h6 class="text-h6 text-typo mb-2">Friends</h6>
          <v-form
            @submit.prevent="submit"
            class="navbar-search navbar-search-light d-inline-block w-100 mb-4"
            id="navbar-search-main"
          >
            <v-text-field
              rounded-sm
              hide-details
              outlined
              dense
              background-color="transparent"
              color="#e91e63"
              label="Search contact"
              class="font-size-input input-style"
            >
            </v-text-field>
          </v-form>
            <a
                    href="javascript:void(0)"
                    class="
    card-shadow
    shadow-blur
    border-radius-xl
    mb-6
    text-decoration-none
  "
                    v-for="(message, i) in messages"
                    :key="message.id"
                    @click="selectUser(message.userId)"
                >
                    <div
                        class="d-flex pa-4 border-radius-xl"
                        :class="{
      'bg-gradient-primary': selectedUser === message.userId,  // Classe active si sélectionné
      'bg-white': selectedUser !== message.userId  // Classe par défaut sinon
    }"
                    >
                        <v-avatar size="48">
                            <img :src="message.image" alt="Avatar" />
                        </v-avatar>
                        <div class="ms-3">
                            <h6
                                class="text-h6 mb-0"
                                :class="selectedUser === message.userId ? 'text-white' : 'text-typo'"
                            >
                                {{ message.name }}
                            </h6>
                            <p
                                class="
          mb-0
          font-weight-light
          text-truncate
          d-block
          text-sm
        "
                                :class="selectedUser === message.userId ? 'text-white' : 'text-body'"
                            >
                                {{ message.message }}
                            </p>
                            <p
                                class="text-muted text-xs mb-2 font-weight-light"
                                v-if="message.time"
                            >
                                {{ message.time }}
                            </p>
                        </div>
                    </div>
                </a>
        </v-card>
      </v-col>
      <v-col md="8">
        <v-card class="pt-8 px-1 shadow-blur">
          <div class="mt-n4">
            <div
              class="
                bg-gradient-primary
                shadow-primary
                border-radius-lg
                px-3
                py-2
                mx-3
              "
            >
              <v-container>
                <v-row>
                  <v-col md="10">
                    <div class="d-flex align-items-center">
                      <v-avatar size="48">
                        <img src="@/assets/img/team-2.jpg" alt="Avatar" />
                      </v-avatar>
                      <div class="ms-3">
                        <h6 class="mb-0 text-h6 d-block text-white">
                          Charlie Watson
                        </h6>
                        <span class="text-sm text-white opacity-8"
                          >last seen today at 1:53am</span
                        >
                      </div>
                    </div>
                  </v-col>
                  <v-col cols="1" class="my-auto">
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-icon
                          v-bind="attrs"
                          v-on="on"
                          size="18"
                          class="material-icons-round text-white"
                        >
                          videocam
                        </v-icon>
                      </template>
                      <span>Video call</span>
                    </v-tooltip>
                  </v-col>
                  <v-col cols="1" class="my-auto">
                    <v-menu
                      transition="slide-y-transition"
                      offset-y
                      offset-x
                      min-width="150"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          icon
                          :ripple="false"
                          class="text-secondary"
                          v-bind="attrs"
                          v-on="on"
                          small
                        >
                          <v-icon
                            size="18"
                            class="material-icons-round text-white"
                            >settings</v-icon
                          >
                        </v-btn>
                      </template>

                      <v-list class="pa-2">
                        <v-list-item
                          class="list-item-hover-active border-radius-md"
                        >
                          <v-list-item-content class="pa-0">
                            <v-list-item-title
                              class="
                                text-body
                                ls-0
                                text-typo
                                font-weight-600
                                mb-0
                              "
                            >
                              Profile
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                          class="list-item-hover-active border-radius-md"
                        >
                          <v-list-item-content class="pa-0">
                            <v-list-item-title
                              class="
                                text-body
                                ls-0
                                text-typo
                                font-weight-600
                                mb-0
                              "
                            >
                              Mute Conversation
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                          class="list-item-hover-active border-radius-md"
                        >
                          <v-list-item-content class="pa-0">
                            <v-list-item-title
                              class="
                                text-body
                                ls-0
                                text-typo
                                font-weight-600
                                mb-0
                              "
                            >
                              Block
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                          class="list-item-hover-active border-radius-md"
                        >
                          <v-list-item-content class="pa-0">
                            <v-list-item-title
                              class="
                                text-body
                                ls-0
                                text-typo
                                font-weight-600
                                mb-0
                              "
                            >
                              Clear Chat
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item
                          class="list-item-hover-active border-radius-md"
                        >
                          <v-list-item-content class="pa-0">
                            <v-list-item-title
                              class="text-danger ls-0 font-weight-600 mb-0"
                            >
                              Delete Chat
                            </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-container>
            </div>
          </div>
            <div ref="chatContainer" class="max-vh-50 overflow-scroll pt-6 px-4">
                <div v-for="chat in chats" :key="chat.id">
                    <!-- Message reçu -->
                    <v-row class="justify-start mb-3" v-if="chat.type === 'received'">
                        <v-col cols="auto">
                            <v-card class="py-2 px-3 shadow border-radius-xl">
                                <p class="mb-1 text-body font-weight-light" v-if="chat.message">
                                    {{ chat.message }}
                                </p>
                                <div class="w-100 position-relative" v-if="chat.image">
                                    <v-img
                                        class="img-fluid mb-2 border-radius-lg"
                                        :src="chat.image"
                                        max-width="200"
                                    ></v-img>
                                </div>
                                <div class="d-flex align-center text-sm text-body opacity-6" v-if="chat.time">
                                    <i class="ni ni-check-bold text-sm me-1"></i>
                                    <small>{{ chat.time }}</small>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>

                    <!-- Message envoyé -->
                    <v-row class="justify-end text-end mb-3" v-else>
                        <v-col cols="auto">
                            <v-card class="py-2 px-3 shadow bg-gradient-primary border-radius-xl">
                                <p class="mb-1 font-weight-light text-white" v-if="chat.message">
                                    {{ chat.message }}
                                </p>
                                <div class="d-flex align-center justify-end text-sm text-white opacity-6" v-if="chat.time">
                                    <i class="ni ni-check-bold text-sm me-1"></i>
                                    <small>{{ chat.time }}</small>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>
                </div>
            </div>
          <div class="py-4 px-4">
            <v-form
              @submit.prevent="submit"
              class="d-flex w-100"
              id="navbar-search-main"
            >
              <v-text-field
                  v-model="newMessage"
                rounded-sm
                outlined
                dense
                hide-details
                background-color="transparent"
                color="#e91e63"
                label="Type your message"
                class="font-size-input input-style"
              >
              </v-text-field>
              <v-btn @click="sendMessage(chats[0].userId)" elevation="0" class="bg-gradient-primary ms-2" height="40">
                <v-icon class="material-icons-round text-white">send</v-icon>
              </v-btn>
            </v-form>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>

import MercureService from "../../../services/mercureService";
import MessageService from "../../../services/message.service"; // Assure-toi d'importer le service Message
import {mapGetters} from "vuex";

export default {
    name: "Teams",
    data() {
        return {
            messages: [],
            chats: [],
            newMessage: '',
            mercureServices: [],
            selectedUser: null
        };
    },
    updated() {
        this.$nextTick(() => {
            this.scrollToBottom();
        });
    },
    methods: {
        async sendMessage(id) {
            if (this.newMessage.trim() === '') {
                return;
            }
            try {
                const response = await MessageService.addMessage(this.newMessage, id);

                this.chats.push({
                    message: this.newMessage,
                    time: new Date().toLocaleTimeString(),
                    type: 'sent',
                });

                this.newMessage = '';
            } catch (error) {
                console.error('Error', error);
            }
        },
        scrollToBottom() {
            const container = this.$refs.chatContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },
        handleNewMessage(newMessage) {
            this.chats.push(newMessage);
        },
        setupMercureListeners() {
            const jwt = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.NFCEbEEiI7zUxDU2Hj0YB71fQVT8YiQBGQWEyxWG0po';

            if (this.users && this.users.length > 0) {
                this.users.forEach((user) => {
                    if (user.username !== this.$store.state.auth.user.username) {
                        const topic = `/chat/messages/${this.$store.state.auth.user.username}/${user.username}`;
                        const mercureService = new MercureService(topic, jwt, user.username, this.$store.state.auth.user.id);
                        mercureService.listen(this.handleNewMessage);
                        this.mercureServices.push(mercureService);
                    }
                });
            }
        },
        getMessages() {
            if (this.users && this.users.length > 0) {
                this.messages = [];
                this.chats = [];
                this.users.forEach((user) => {
                    MessageService.getMessages(user.id).then(
                        (response) => {
                            if (response.data.messages.length !== 0) {
                                this.chats.push(...response.data.messages);
                            }
                            if (response.data.listUserConversations.length !== 0) {
                                this.messages.push(Object.values(response.data.listUserConversations)[0]);
                            }
                        },
                        (error) => {
                            console.error(
                                (error.response && error.response.data) ||
                                error.message ||
                                error.toString()
                            );
                        }
                    );
                });

                this.setupMercureListeners();
            }
        },
        selectUser(user) {
            this.selectedUser = user;
            // Filtre les messages par utilisateur
            MessageService.getMessages(user).then(
                (response) => {
                    this.chats = [];
                    this.chats = response.data.messages;

                    if (this.chats && this.chats.length > 0) {
                        const emptyMessage = [{
                            id: 1,
                            userId: user,
                            name: this.$store.state.auth.user.username,
                            message: '',
                        }];
                        this.chats.push(emptyMessage);
                    }
                },
                (error) => {
                    console.error(error);
                }
            );
        }
    },
    watch: {
        users(newUsers) {
            if (newUsers.length > 0) {
                this.getMessages();
            }
        }
    },
    computed: {
        ...mapGetters('users', ['users']),
    },
    created() {
        this.$store.dispatch('users/fetchUsers');
    },
    mounted() {
        this.scrollToBottom();
    },
    beforeDestroy() {
        this.mercureServices.forEach((service) => {
            service.close();
        });
    }
};


</script>
<style scoped>
.max-vh-50 {
    max-height: 50vh; /* Limite la hauteur à 50% de la vue */
}
</style>
