<template>
    <v-card class="card-shadow border-radius-xl mt-6" id="basic">
        <div class="px-6 py-6">
            <h5 class="text-h5 font-weight-bold text-typo">Basic Info</h5>
        </div>
        <div class="px-6 pb-6 pt-0">
            <v-row>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.firstName"
                        color="#e91e63"
                        label="First Name"
                        placeholder="Alex"
                        class="font-size-input input-style"
                    ></v-text-field>
                </v-col>
                <v-col cols="6">
                    <v-text-field
                        v-model="form.lastName"
                        color="#e91e63"
                        label="Last Name"
                        placeholder="Thompson"
                        class="font-size-input input-style"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="mt-0">
                <v-col sm="4" cols="12">
                    <label class="text-sm text-body">I'm</label>
                    <v-select
                        v-model="form.gender"
                        :items="gender"
                        label="Male"
                        color="#e91e63"
                        class="font-size-input input-style"
                        single-line
                        height="36"
                    ></v-select>
                </v-col>
                <v-col sm="8">
                    <v-row>
                        <v-col cols="5">
                            <label class="text-sm text-body">Birth Date</label>
                            <v-select
                                v-model="form.birthMonth"
                                :items="months"
                                label="February"
                                color="#e91e63"
                                class="font-size-input input-style"
                                single-line
                                height="36"
                            ></v-select>
                        </v-col>
                        <v-col sm="4" cols="3">
                            <v-select
                                v-model="form.birthDay"
                                :items="days"
                                label="1"
                                color="#e91e63"
                                class="font-size-input input-style mt-7"
                                single-line
                                height="36"
                            ></v-select>
                        </v-col>
                        <v-col sm="3" cols="4">
                            <v-select
                                v-model="form.birthYear"
                                :items="years"
                                label="2022"
                                color="#e91e63"
                                class="font-size-input input-style mt-7"
                                single-line
                                height="36"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" class="py-0">
                    <v-text-field
                        v-model="form.email"
                        color="#e91e63"
                        label="Email"
                        placeholder="example@email.com"
                        class="font-size-input input-style"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="py-0">
                    <v-text-field
                        v-model="form.confirmEmail"
                        color="#e91e63"
                        label="Confirmation Email"
                        placeholder="example@email.com"
                        class="font-size-input input-style"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" class="py-0">
                    <v-text-field
                        v-model="form.location"
                        color="#e91e63"
                        label="Your Location"
                        placeholder="Sydney, A"
                        class="font-size-input input-style"
                    ></v-text-field>
                </v-col>
                <v-col cols="6" class="py-0">
                    <v-text-field
                        v-model="form.phoneNumber"
                        color="#e91e63"
                        label="Phone Number"
                        placeholder="+40 735 631 620"
                        class="font-size-input input-style"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" class="pb-0">
                    <label class="text-sm text-body">Language</label>
                    <v-select
                        v-model="form.language"
                        :items="languages"
                        label="English"
                        color="#e91e63"
                        class="font-size-input input-style"
                        single-line
                        height="36"
                    ></v-select>
                </v-col>
                <v-col cols="6">
                    <label class="text-sm text-body">Skills</label>
                    <v-select
                        v-model="form.skills"
                        :items="skills"
                        color="#e91e63"
                        class="font-size-input input-style"
                        single-line
                        chips
                        multiple
                        height="36"
                    ></v-select>
                </v-col>
                <v-btn
                    @click="updateProfile"
                    color="#cb0c9f"
                    class="font-weight-bolder btn-default bg-gradient-default py-4 px-8 ms-auto mt-sm-auto mt-4"
                    small
                >
                    Update Information
                </v-btn>
            </v-row>
        </div>
    </v-card>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    name: "basic-info",
    data() {
        return {
            gender: ["Female", "Male"],
            months: [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December",
            ],
            days: Array.from({ length: 31 }, (v, k) => k + 1),
            years: ["2021", "2020", "2019"],
            languages: ["English", "French", "Spanish"],
            skills: ["vuejs", "angular", "react"],
            form: {
                firstName: '',
                lastName: '',
                gender: 'Male',
                birthMonth: 'February',
                birthDay: '1',
                birthYear: '2021',
                email: '',
                confirmEmail: '',
                location: '',
                phoneNumber: '',
                language: 'English',
                skills: [],
            },
        };
    },
    watch: {
        user: {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.form.firstName = newValue.firstName || '';
                    this.form.lastName = newValue.lastName || '';
                    this.form.email = newValue.email || '';
                }
            }
        },
        profile: {
            immediate: true,
            handler(newValue) {
                if (newValue) {
                    this.form.gender = newValue.gender || 'Male';
                    this.form.birthMonth = newValue.birthMonth || 'February';
                    this.form.birthDay = newValue.birthDay || '1';
                    this.form.birthYear = newValue.birthYear || '2021';
                    this.form.location = newValue.location || '';
                    this.form.phoneNumber = newValue.phoneNumber || '';
                    this.form.language = newValue.language || 'English';
                    this.form.skills = newValue.skills || [];
                }
            }
        }
    },
    computed: {
        ...mapGetters('profile', ['profile']),
        ...mapGetters('user', ['user']),
    },
    methods: {
        updateProfile() {
            axios.post('/api/profile/update', this.form)
                .then(response => {
                })
                .catch(error => {
                    console.error("There was an error updating the profile", error);
                });
        }
    },
};
</script>
