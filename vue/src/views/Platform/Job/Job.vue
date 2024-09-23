<template>
  <v-container fluid class="py-6">
      <v-card class="mx-auto">
          <v-card-title>
              <v-row justify="center">
              <h1>Jobs</h1>
              </v-row>
          </v-card-title>
          <v-card-text class="py-4">
              <v-row justify="center">
                  <v-btn elevation="0"
                         :ripple="false"
                         height="43"
                         class="
                    font-weight-bold
                    text-uppercase
                    btn-primary
                    bg-gradient-primary
                    py-2
                    px-6
                    me-2
                    text-xs
                  "  @click="showCandidatureModal = true">New Candidature</v-btn>
                  <v-btn elevation="0"
                         :ripple="false"
                         height="43"
                         class="
                    font-weight-bold
                    text-uppercase
                    btn-primary
                    bg-gradient-primary
                    py-2
                    px-6
                    me-2
                    text-xs
                  " @click="showJobModal = true">New Job/Training</v-btn>
              </v-row>
              <v-row>
                  <v-col cols="12" sm="3">
                      <v-select
                          v-model="selectedCategory"
                          :items="categories"
                          item-text="name"
                          item-value="name"
                          label="Category"
                          multiple
                          chips
                          outlined
                          dense
                      ></v-select>
                  </v-col>

                  <v-col cols="12" sm="3">
                      <v-autocomplete
                          v-model="selectedLocales"
                          :items="locales"
                          label="Location"
                          multiple
                          chips
                          outlined
                          dense
                          item-text="name"
                          item-value="id"
                      ></v-autocomplete>
                  </v-col>

                  <v-col cols="12" sm="4">
                      <v-text-field
                          rounded-sm
                          background-color="transparent"
                          v-model="searchJobs"
                          dense
                          hide-details
                          outlined
                          label="Search here"
                          class="input-style font-size-input me-md-3"
                      >
                      </v-text-field>
                  </v-col>
                  <v-col cols="12" sm="1">
                      <v-btn elevation="0"
                             :ripple="false"
                             height="43"
                             class="
                    font-weight-bold
                    text-uppercase
                    btn-primary
                    bg-gradient-primary
                    py-2
                    px-6
                    me-2
                    text-xs
                  " @click="applyFilters">Filter</v-btn>
                  </v-col>
                  <v-col cols="12" sm="1">
                      <v-btn text @click="resetFilters">Reset</v-btn>
                  </v-col>


              </v-row>
          </v-card-text>
          <v-dialog v-model="showJobModal" max-width="600px">
              <v-card>
                  <v-card-title>
                      <span class="text-h5">New Job</span>
                  </v-card-title>
                  <v-card-text>
                      <v-form>
                          <v-select
                              v-model="selectedCategories"
                              :items="categories"
                              item-text="name"
                              item-value="name"
                          label="Category"
                          multiple
                          chips
                          outlined
                          ></v-select>
                          <!-- Champs pour le job -->
                          <v-text-field v-model="jobForm.title" label="Job title" outlined dense></v-text-field>
                          <v-textarea v-model="jobForm.description" label="Description of the job" outlined dense></v-textarea>
                          <v-text-field v-model="jobForm.requiredSkills" label="Required Skills" outlined dense></v-text-field>
                          <v-select
                              v-model="jobForm.experience"
                              :items="['Junior', 'Mid-level', 'Senior']"
                              label="Experience"
                              outlined
                          ></v-select>

                          <!-- Vérification si l'utilisateur a une companyId -->
                          <template v-if="this.user.company">
                              <v-text-field v-model="this.user.company.name" label="Company Name" outlined readonly></v-text-field>
                          </template>

                          <template v-else>
                              <!-- Champs supplémentaires pour la société si l'utilisateur n'a pas de companyId -->
                              <v-text-field v-model="jobForm.companyName" label="Company Name" outlined dense></v-text-field>
                              <v-textarea v-model="jobForm.companyDescription" label="Company Description" outlined dense></v-textarea>
                              <v-text-field v-model="jobForm.location" label="Location" outlined dense></v-text-field>
                              <dropzone class="my-dropzone" v-model="fileSingle"></dropzone>
                          </template>
                      </v-form>
                  </v-card-text>
                  <v-card-actions>
                      <v-btn color="primary" @click="submitJobForm">Submit</v-btn>
                      <v-btn text @click="closeJobModal">Cancel</v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>

          <!-- Modal pour New Candidature -->
          <v-dialog v-model="showCandidatureModal" max-width="600px">
              <v-card>
                  <v-card-title>
                      <span class="text-h5">New Candidature</span>
                  </v-card-title>
                  <v-card-text>
                      <v-form>
                          <!-- Champs pour la candidature -->
                          <v-text-field v-model="candidatureForm.name" label="Applicant Name" outlined dense></v-text-field>
                          <v-textarea v-model="candidatureForm.jobPreferences" label="Job Preferences" outlined dense></v-textarea>
                      </v-form>
                  </v-card-text>
                  <v-card-actions>
                      <v-btn color="primary" @click="submitCandidatureForm">Submit</v-btn>
                      <v-btn text @click="closeCandidatureModal">Cancel</v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>
      </v-card>
      <v-row class="mb-6 mt-10">
          <v-col
              v-for="(item, i) in jobs"
              :key="item.title + i"
              lg="4"
              class="pt-0 mb-lg-0 mb-10"
          >
              <v-card
                  class="card card-shadow border-radius-xl py-5 text-center"
                  data-animation="true"
              >
                  <div class="mt-n5 mx-4 card-header position-relative z-index-2">
                      <div class="d-block blur-shadow-image">
                          <!-- Lien sur l'image -->
                          <router-link
                              :to="{ name: 'JobDetail', params: { id: item.id } }"
                              class="text-decoration-none"
                          >
                              <img
                                  :src="'http://localhost/uploads/' + item.company.image"
                                  class="img-fluid shadow border-radius-lg"
                                  :alt="item.company.image"
                              />
                          </router-link>
                      </div>
                      <div
                          class="colored-shadow"
                          v-bind:style="{ backgroundImage: 'url(' + 'http://localhost/uploads/' + item.company.image + ')' }"
                      ></div>
                  </div>

                  <div class="d-flex mx-auto mt-n8">
                      <v-tooltip bottom>
                          <template v-slot:activator="{ on, attrs }">
                              <v-icon
                                  v-bind="attrs"
                                  v-on="on"
                                  class="material-icons-round text-primary ms-auto px-5"
                                  size="18"
                              >
                                  refresh
                              </v-icon>
                          </template>
                          <span>Refresh</span>
                      </v-tooltip>
                      <v-tooltip bottom>
                          <template v-slot:activator="{ on, attrs }">
                              <v-icon
                                  v-bind="attrs"
                                  v-on="on"
                                  class="material-icons-round text-info me-auto px-5"
                                  size="18"
                              >
                                  edit
                              </v-icon>
                          </template>
                          <span>Edit</span>
                      </v-tooltip>
                  </div>

                  <!-- Lien sur le titre -->
                  <h5 class="font-weight-normal text-typo text-h5 mt-7 mb-2 px-4">
                      <router-link
                          :to="{ name: 'JobDetail', params: { id: item.id } }"
                          class="text-decoration-none text-default"
                      >
                          {{ item.title }}
                      </router-link>
                  </h5>

                  <p class="mb-0 text-body font-weight-light px-5">
                      {{ item.description }}
                  </p>
                  <hr class="horizontal dark my-6" />
                  <div class="d-flex text-body mx-2 px-4">
                      <p class="mb-0 font-weight-normal text-body">
                          {{ item.experience }}
                      </p>
                      <i
                          class="
            material-icons-round
            position-relative
            ms-auto
            text-lg
            me-1
            my-auto
          "
                      >
                          place
                      </i>
                      <p class="text-sm my-auto font-weight-light">
                          {{ item.company.location }}
                      </p>
                  </div>
              </v-card>
          </v-col>
      </v-row>

  </v-container>
</template>
<script>

import JobService from "../../../services/job.service";
import {mapGetters} from "vuex";
import Dropzone from "../../Ecommerce/Products/Widgets/Dropzone.vue";

export default {
  name: "Job",
  components: {
      Dropzone
  },
  data: function () {
    return {
        selectedCategory: [],
        selectedLocales: null,
        searchJobs: '',
        categories: [
            { id: 1, name: 'Informatique' },
            { id: 2, name: 'Finance' },
            { id: 3, name: 'Marketing' },
            { id: 4, name: 'Ressources Humaines' }
        ],
        selectedCategories: [],
        locales: [
            { id: 1, name: 'Germany' },
            { id: 2, name: 'France' },
            { id: 3, name: 'USA' }
        ],
        showJobModal: false,
        showCandidatureModal: false,
        companyId: null,
        jobs: [],
        jobForm: {
            title: '',
            description: '',
            requiredSkills: '',
            experience: 'Junior',
            companyId: '',
            companyName: '',
            companyDescription: '',
            location: '',
            categories: [],
            company: null
        },
        candidatureForm: {
            name: '',
            jobPreferences: '',
        },
        fileSingle: [],
    };
  },
    methods: {
        applyFilters() {
            let searchFilter = {
                categories: this.selectedCategory,
                locales: this.selectedLocales,
                search: this.searchJobs
            };
            JobService.getFilteredJobs(searchFilter).then(response => {
                    this.jobs = [];
                    this.jobs.push(response.data);
                    searchFilter = {};

            }).catch(err => {
                console.error(err);
                this.loading = false;
                this.error = true;
            });
        },
        resetFilters() {
            this.selectedCategory = null;
            this.selectedLocales = null;
            this.searchJobs = '';
        },
        submitJobForm() {
            this.jobForm.categories = this.selectedCategories;
            if (this.user.company) {
                this.jobForm.company = {
                    id: this.user.company.id,
                    name: this.user.company.name,
                    location: this.user.company.location,
                    image: this.user.company.image
                };
            }

            const payload = {
                job: this.jobForm,
                categories: this.selectedCategories
            };
            JobService.createJob(payload).then(data => {
                console.log(data);
                this.jobForm.id = data.data.id;
                this.job.push(this.jobForm);
                this.closeJobModal();
            }).catch(err => {
                console.error(err);
                this.loading = false;
                this.error = true;
            });
        },
        submitCandidatureForm() {
            this.closeCandidatureModal();
        },
        closeJobModal() {
            this.showJobModal = false;
            this.resetJobForm();
        },
        closeCandidatureModal() {
            this.showCandidatureModal = false;
            this.resetCandidatureForm();
        },
        resetJobForm() {
            this.jobForm = {
                title: '',
                description: '',
                requiredSkills: '',
                experience: 'Junior',
                companyId: this.companyId ? this.companyId : '',
                companyName: '',
                companyDescription: '',
                location: '',
                categories: []
            };
        },
        resetCandidatureForm() {
            this.candidatureForm = {
                name: '',
                jobPreferences: '',
            };
        },
    },
    computed: {
        ...mapGetters('user', ['user']),
        ...mapGetters('job', ['job'])
    },
    created() {
        this.$store.dispatch('job/fetchJobs');
        this.$store.dispatch('user/fetchUser');
        if (this.user) {
            this.jobs = this.job;
            this.jobForm.companyName = this.user.company.name;
            console.log(this.jobForm.companyName)
        }
    },
    mounted() {
        setTimeout(() => {
            this.jobs = this.job;
            this.$store.dispatch('user/fetchUser');
            if (this.user.company.companyName) {
                this.jobForm.companyName = this.user.company.name;
                console.log(this.jobForm.companyName)
            }
        }, 1000);
    }
};
</script>
