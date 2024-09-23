<template>
    <v-container fluid class="py-6">
        <div
            class="
            min-height-100
            border-radius-xl
            overflow-hidden
            position-relative
            mt-6
            mx-3
          "
            :style="`background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-position: 50%; background-size: cover;`"
        >
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <v-card
            class="shadow px-4 py-4 mx-9 overflow-hidden border-radius-xl mt-n16"
        >
            <v-row>
                <v-col cols="auto">
                    <v-avatar width="74" height="74" class="shadow border-radius-lg">
                        <img
                            src="@/assets/img/bruce-mars.jpg"
                            alt="Avatar"
                            class="border-radius-lg"
                        />
                    </v-avatar>
                </v-col>
                <v-col cols="auto" class="my-auto">
                    <div class="h-100">
                        <h5 class="mb-1 text-h5 text-typo font-weight-bold" v-if="user && user.firstName && user.lastName">
                            {{ user.firstName }} {{ user.lastName }}
                        </h5>
                        <p class="mb-0 font-weight-light text-body text-sm" v-if="profile && profile.title">
                            {{ profile.title }}
                        </p>
                    </div>
                </v-col>
                <v-col
                    lg="4"
                    md="6"
                    class="my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3"
                >
                    <v-tabs background-color="transparent" right>
                        <v-tabs-slider></v-tabs-slider>

                        <v-tab :ripple="false" href="#tab-1">
                            <svg
                                class="text-dark me-1"
                                width="16px"
                                height="16px"
                                viewBox="0 0 42 42"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                            >
                                <g
                                    stroke="none"
                                    stroke-width="1"
                                    fill="none"
                                    fill-rule="evenodd"
                                >
                                    <g
                                        transform="translate(-2319.000000, -291.000000)"
                                        fill="#FFFFFF"
                                        fill-rule="nonzero"
                                    >
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(603.000000, 0.000000)">
                                                <path
                                                    class="color-background"
                                                    d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"
                                                ></path>
                                                <path
                                                    class="color-background"
                                                    d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                    opacity="0.7"
                                                ></path>
                                                <path
                                                    class="color-background"
                                                    d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                    opacity="0.7"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="ms-1">App</span>
                        </v-tab>

                        <v-tab :ripple="false" href="#tab-2">
                            <svg
                                class="text-dark me-1"
                                width="16px"
                                height="16px"
                                viewBox="0 0 40 44"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                            >
                                <title>document</title>
                                <g
                                    stroke="none"
                                    stroke-width="1"
                                    fill="none"
                                    fill-rule="evenodd"
                                >
                                    <g
                                        transform="translate(-1870.000000, -591.000000)"
                                        fill="#FFFFFF"
                                        fill-rule="nonzero"
                                    >
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(154.000000, 300.000000)">
                                                <path
                                                    class="color-background"
                                                    d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                    opacity="0.603585379"
                                                ></path>
                                                <path
                                                    class="color-background"
                                                    d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="ms-1">Messages</span>
                        </v-tab>

                        <v-tab :ripple="false" href="#tab-3">
                            <svg
                                class="text-dark me-1"
                                width="16px"
                                height="16px"
                                viewBox="0 0 40 40"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                            >
                                <title>settings</title>
                                <g
                                    stroke="none"
                                    stroke-width="1"
                                    fill="none"
                                    fill-rule="evenodd"
                                >
                                    <g
                                        transform="translate(-2020.000000, -442.000000)"
                                        fill="#FFFFFF"
                                        fill-rule="nonzero"
                                    >
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(304.000000, 151.000000)">
                                                <polygon
                                                    class="color-background"
                                                    opacity="0.596981957"
                                                    points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"
                                                ></polygon>
                                                <path
                                                    class="color-background"
                                                    d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"
                                                    opacity="0.596981957"
                                                ></path>
                                                <path
                                                    class="color-background"
                                                    d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="ms-1">Settings</span>
                        </v-tab>
                    </v-tabs>
                </v-col>
            </v-row>
            <fade-transition
                :duration="200"
                origin="center top"
                mode="out-in"
            >
                <!-- your content here -->
                <router-view></router-view>
            </fade-transition>
            <v-row>
                <v-col lg="4" md="6" cols="12" class="position-relative">
                    <v-card class="h-100">
                        <div class="pt-4">
                            <h6 class="mb-0 text-h6 text-typo">Platform Settings</h6>
                        </div>
                        <div class="py-4">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">
                                Account
                            </h6>
                            <v-list>
                                <v-list-item-group class="border-radius-sm">
                                    <v-list-item
                                        :ripple="false"
                                        v-for="setting in accountSettings"
                                        :key="setting.text"
                                        class="pe-2 ps-0 border-radius-sm mb-3"
                                    >
                                        <v-switch
                                            :ripple="false"
                                            class="d-inline-flex mt-0 pt-0 switch ms-auto"
                                            v-model="setting.switchState"
                                            hide-details
                                        ></v-switch>
                                        <v-list-item-content class="py-0">
                                            <div class="ms-4 text-body text-sm">
                                                {{ setting.text }}
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                            <h6
                                class="text-uppercase text-body text-xs font-weight-bolder mt-4"
                            >
                                Application
                            </h6>
                            <v-list>
                                <v-list-item-group class="border-radius-sm">
                                    <v-list-item
                                        :ripple="false"
                                        v-for="setting in applicationSettings"
                                        :key="setting.text"
                                        class="px-0 border-radius-sm mb-3"
                                    >
                                        <v-switch
                                            :ripple="false"
                                            class="d-inline-flex mt-0 pt-0 switch ms-auto"
                                            v-model="setting.switchState"
                                            hide-details
                                        ></v-switch>
                                        <v-list-item-content class="py-0">
                                            <div class="ms-4 text-body text-sm">
                                                {{ setting.text }}
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </div>
                    </v-card>
                    <hr class="vertical dark" />
                </v-col>
                <v-col lg="4" md="6" cols="12" class="position-relative">
                    <v-card class="h-100">
                        <div class="px-4 pt-4">
                            <h6 class="mb-0 text-h6 text-typo">Profile Information</h6>
                        </div>
                        <div class="px-4 py-4">
                            <p class="text-sm font-weight-light text-body">
                                {{ profile ? profile.description : 'Empty' }}
                            </p>
                            <hr class="horizontal dark mt-6 mb-3" />
                            <v-list>
                                <v-list-item-group class="border-radius-sm">
                                    <v-list-item :ripple="false" class="px-0 border-radius-sm">
                                        <v-list-item-content class="py-0">
                                            <div class="text-body text-sm">
                                                <strong class="text-dark">Full Name:</strong>
                                                &nbsp; {{ user ? user.firstName + ' ' + user.lastName : 'Empty' }}
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item :ripple="false" class="px-0 border-radius-sm">
                                        <v-list-item-content class="py-0">
                                            <div class="text-body text-sm">
                                                <strong class="text-dark">Mobile:</strong>
                                                &nbsp; {{ profile ? profile.mobile : 'Empty' }}
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item :ripple="false" class="px-0 border-radius-sm">
                                        <v-list-item-content class="py-0">
                                            <div class="text-body text-sm">
                                                <strong class="text-dark">Email:</strong>
                                                &nbsp; {{ user ? user.email : 'Empty' }}
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item :ripple="false" class="px-0 border-radius-sm">
                                        <v-list-item-content class="py-0">
                                            <div class="text-body text-sm">
                                                <strong class="text-dark">Location:</strong>
                                                &nbsp; USA
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item :ripple="false" class="px-0 border-radius-sm">
                                        <v-list-item-content class="py-0">
                                            <div class="text-body text-sm">
                                                <strong class="text-dark">Social:</strong>
                                                &nbsp;
                                                <v-icon color="#344e86" class="mt-n1 ps-1 pe-2"
                                                >fab fa-facebook fa-lg</v-icon
                                                >
                                                <v-icon color="#3ea1ec" class="mt-n1 ps-1 pe-2"
                                                >fab fa-twitter fa-lg</v-icon
                                                >
                                                <v-icon color="#0e456d" class="mt-n1 ps-1 pe-2"
                                                >fab fa-instagram fa-lg</v-icon
                                                >
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </div>
                    </v-card>
                    <hr class="vertical dark" />
                </v-col>
                <v-col lg="4" cols="12">
                    <v-card class="h-100">
                        <div class="px-4 pt-4">
                            <h6 class="mb-0 text-h6 text-typo">Conversations</h6>
                        </div>
                        <div class="px-4 py-4">
                            <v-list>
                                <v-list-item-group class="border-radius-sm">
                                    <v-list-item
                                        :ripple="false"
                                        v-for="conversation in conversations"
                                        :key="conversation.text"
                                        class="px-0 border-radius-sm mb-2"
                                    >
                                        <v-avatar
                                            width="48"
                                            height="48"
                                            class="shadow border-radius-lg me-4"
                                        >
                                            <img
                                                :src="conversation.avatar"
                                                alt="Avatar"
                                                class="border-radius-lg"
                                            />
                                        </v-avatar>
                                        <v-list-item-content>
                                            <div class="d-flex align-center">
                                                <div>
                                                    <h6
                                                        class="
                            mb-0
                            text-sm text-sm text-typo
                            font-weight-bold
                          "
                                                    >
                                                        {{ conversation.user }}
                                                    </h6>
                                                    <p class="mb-0 text-xs text-body font-weight-light">
                                                        {{ conversation.message }}
                                                    </p>
                                                </div>
                                                <div class="ms-auto">
                                                    <v-btn
                                                        :ripple="false"
                                                        small
                                                        text
                                                        width="auto"
                                                        class="pe-4 ps-0 mb-0 text-primary font-weight-bolder"
                                                    >
                                                        Reply
                                                    </v-btn>
                                                </div>
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <div class="px-4 pt-4">
                            <h6 class="mb-1 text-typo text-h6 font-weight-bold">Projects</h6>
                            <p class="text-sm text-body">Architects design houses</p>
                        </div>
                        <div class="px-4 py-4">
                            <v-row>
                                <v-col v-for="card in cards" :key="card.title" lg="3" md="6">
                                    <v-card>
                                        <div class="position-relative">
                                            <a class="d-block shadow-xl border-radius-xl">
                                                <v-img :src="card.image" class="shadow border-radius-xl">
                                                </v-img>
                                            </a>
                                        </div>
                                        <div class="px-1 pt-6">
                                            <p class="text-body font-weight-light mb-0 text-sm">
                                                {{ card.title }}
                                            </p>
                                            <a href="javascript:" class="text-decoration-none">
                                                <h5 class="text-h5 font-weight-bold text-typo mb-2">
                                                    {{ card.style }}
                                                </h5>
                                            </a>
                                            <p class="mb-6 text-sm text-body font-weight-light">
                                                {{ card.description }}
                                            </p>
                                            <div class="d-flex align-center justify-space-between">
                                                <v-btn
                                                    outlined
                                                    color="#e91e63"
                                                    class="font-weight-bolder py-4 px-5"
                                                    small
                                                >
                                                    View Project
                                                </v-btn>
                                                <span class="avatar-group d-flex">
                        <v-tooltip
                            bottom
                            color="#212529"
                            v-for="avatar in card.avatars"
                            :key="avatar.name"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            <v-avatar
                                v-bind="attrs"
                                v-on="on"
                                size="24"
                                class="border border-white ms-n3"
                            >
                              <img :src="avatar.image" alt="Avatar" />
                            </v-avatar>
                          </template>
                          <span>{{ avatar.name }}</span>
                        </v-tooltip>
                      </span>
                                            </div>
                                        </div>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>
<script>

import { mapGetters } from 'vuex';

export default {
    name: "Profile",
    data: function () {
        return {
            accountSettings: [
                {
                    switchState: true,
                    text: "Email me when someone follows me",
                },
                {
                    switchState: false,
                    text: "Email me when someone answers on...",
                },
                {
                    switchState: true,
                    text: "Email me when someone mentions me...",
                },
            ],
            applicationSettings: [
                {
                    switchState: false,
                    text: "New launches and projects",
                },
                {
                    switchState: true,
                    text: "Monthly product updates",
                },
                {
                    switchState: false,
                    text: "Subscribe to newsletter",
                },
            ],
            conversations: [
                {
                    avatar: require("@/assets/img/kal-visuals-square.jpg"),
                    user: "Sophie B.",
                    message: "Hi! I need more information..",
                },
                {
                    avatar: require("@/assets/img/marie.jpg"),
                    user: "Anne Marie",
                    message: "Awesome work, can you..",
                },
                {
                    avatar: require("@/assets/img/ivana-square.jpg"),
                    user: "Ivanna",
                    message: "About files I can..",
                },
                {
                    avatar: require("@/assets/img/team-4.jpg"),
                    user: "Peterson",
                    message: "Have a great afternoon..",
                },
                {
                    avatar: require("@/assets/img/team-3.jpg"),
                    user: "Nick Daniel",
                    message: "Hi! I need more information..",
                },
            ],
            cards: [
                {
                    image: require("@/assets/img/home-decor-1.jpg"),
                    title: "Project #2",
                    style: "Modern",
                    description:
                        "As Uber works through a huge amount of internal management turmoil.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                    ],
                },
                {
                    image: require("@/assets/img/home-decor-2.jpg"),
                    title: "Project #1",
                    style: "Scandinavian",
                    description:
                        "Music is something that every person has his or her own specific opinion about.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                    ],
                },
                {
                    image: require("@/assets/img/home-decor-3.jpg"),
                    title: "Project #3",
                    style: "Minimalist",
                    description:
                        "Different people have different taste, and various types of music.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                    ],
                },
                {
                    image: require("@/assets/img/home-decor-4.jpg"),
                    title: "Project #4",
                    style: "Gothic",
                    description:
                        "Why would anyone pick blue over pink? Pink is obviously a better color.",
                    avatars: [
                        {
                            image: require("@/assets/img/team-4.jpg"),
                            name: "Peterson",
                        },
                        {
                            image: require("@/assets/img/team-3.jpg"),
                            name: "Nick Daniel",
                        },
                        {
                            image: require("@/assets/img/team-2.jpg"),
                            name: "Ryan Milly",
                        },
                        {
                            image: require("@/assets/img/team-1.jpg"),
                            name: "Elena Morison",
                        },
                    ],
                },
            ],
        };
    },
    computed: {
        ...mapGetters('profile', ['profile']),
        ...mapGetters('user', ['user']),
    },
};
</script>
