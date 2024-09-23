<template>
    <div>
        <v-container fluid class="py-8 px-6">
            <v-row>
                <v-col cols="12">
                    <v-card class="card-shadow border-radius-xl">
                        <div class="card-padding">
                            <h5 class="text-h5 text-typo font-weight-bold mb-6">
                                Product Details
                            </h5>
                            <v-row>
                                <v-col lg="5" md="6" class="text-center">
                                    <v-img
                                        class="w-100 border-radius-lg shadow-lg mx-auto"
                                        :src="'http://localhost/' + product.medias[0].path + '/' + product.image"
                                    >
                                    </v-img>
                                    <div class="mt-8 overflow-scroll">
                                        <Photoswipe>

                                            <img
                                                v-for="(image, index) in product.medias"
                                                :key="index"
                                                class="me-2"
                                                :src="'http://localhost/' + product.medias[0].path + '/' + image.name"
                                                v-pswp="'http://localhost/' + product.medias[0].path + '/' + image.name"/>
                                        </Photoswipe>
                                    </div>
                                </v-col>
                                <v-col lg="5" class="mx-auto">
                                    <h3
                                        class="text-h3 text-typo font-weight-bold mt-lg-0 mt-4 mb-2"
                                    >
                                        {{ this.product.name }}
                                    </h3>
                                    <div class="rating">
                                        <i class="material-icons-round text-lg text-body">grade</i>
                                        <i class="material-icons-round text-lg text-body ms-1"
                                        >grade</i
                                        >
                                        <i class="material-icons-round text-lg text-body ms-1"
                                        >grade</i
                                        >
                                        <i class="material-icons-round text-lg text-body ms-1"
                                        >grade</i
                                        >
                                        <i class="material-icons-round text-lg text-body ms-1"
                                        >star_outline</i
                                        >
                                    </div>
                                    <br />
                                    <h6 class="text-h6 text-typo mb-0 mt-4 font-weight-bold">
                                        Price
                                    </h6>
                                    <h5 class="text-h5 text-typo mb-1 font-weight-bold">
                                        $ {{ product.price }}
                                    </h5>
                                    <v-btn
                                        elevation="0"
                                        small
                                        :ripple="false"
                                        height="21"
                                        class="
                      border-radius-md
                      font-weight-bolder
                      px-3
                      py-3
                      badge-font-size
                      ms-auto
                      text-success
                    "
                                        color="#bce2be"
                                    >IN STOCK</v-btn
                                    >
                                    <br />
                                    <br />
                                    <label class="text-sm text-body ms-1 mt-6">Description</label>
                                    <ul class="text-body font-weight-light mt-2">
                                        <li>
                                            {{ extractText(product.description) }}</li>
                                    </ul>
                                    <v-row class="mt-6">
                                        <v-col lg="5">
                                            <label class="text-sm text-body mb-0"
                                            >Frame Material</label
                                            >
                                            <v-select
                                                :items="materials"
                                                value="Wood"
                                                color="#e91e63"
                                                class="
                          font-size-input
                          input-style
                          placeholder-light
                          border-radius-md
                          select-style
                          mt-0
                        "
                                                height="36"
                                            >
                                            </v-select>
                                        </v-col>
                                        <v-col lg="5">
                                            <label class="text-sm text-body mb-0">Color</label>
                                            <v-select
                                                :items="colors"
                                                value="Black"
                                                color="#e91e63"
                                                class="
                          font-size-input
                          input-style
                          placeholder-light
                          border-radius-md
                          select-style
                          mt-0
                        "
                                                height="36"
                                            >
                                            </v-select>
                                        </v-col>
                                        <v-col lg="2">
                                            <label class="text-sm text-body mb-0">Quantity</label>
                                            <v-select
                                                :items="numbers"
                                                value="1"
                                                color="#e91e63"
                                                class="
                          font-size-input
                          input-style
                          placeholder-light
                          border-radius-md
                          select-style
                          mt-0
                        "
                                                height="36"
                                            >
                                            </v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col>
                                            <v-btn
                                                elevation="0"
                                                :ripple="false"
                                                height="43"
                                                class="font-weight-bold text-uppercase btn-default bg-gradient-primary shadow-primary py-2 px-6 me-2"
                                                color="#5e72e4"
                                                small
                                                @click="showModal = true"
                                            >
                                                Add To Cart
                                            </v-btn>

                                            <!-- Modal -->
                                            <v-dialog v-model="showModal" max-width="600px">
                                                <v-card>

                                                </v-card>
                                            </v-dialog>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row class="mt-8">
                                <v-col cols="12">
                                    <h5 class="text-h5 text-typo font-weight-bold ms-4">
                                        Other Products
                                    </h5>
                                    <table-products></table-products>
                                </v-col>
                            </v-row>
                        </div>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
import Vue from "vue";
import Photoswipe from "vue-pswipe";
Vue.use(Photoswipe);
import TableProducts from "./Widgets/TableProducts.vue";
import ShopService from "../../../../services/shop.service";
import {mapGetters} from "vuex";
import Dropzone from "./../../Widgets/MediaDropzone.vue";


export default {
    name: "ProductDetail",
    props: ['id'],
    components: {
        Dropzone,
        TableProducts,
    },
    computed: {
        ...mapGetters('user', ['user']),
        ...mapGetters('profile', ['profile']),
    },
    data() {
        return {
            materials: ["Wood", "Aluminium", "Leather"],
            colors: ["White", "Black", "Gray"],
            numbers: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
            product: null,
            showModal: false,
            editedUser: {},
            fileSingle: [],
            form: {
                firstName: '',
                lastName: '',
                email: '',
                mobile: '',
                avatar: null,
                location: '',
                coverLetter: '',
                files: {}
            },
        };
    },
    methods: {
        save() {
            const payload = {
                job: this.id,
                firstName: this.editedUser.firstName,
                lastName: this.editedUser.lastName,
                email: this.editedUser.email,
                mobile: this.editedUser.mobile,
                avatar: this.editedUser.avatar,
                location: this.editedUser.locale,
                coverLetter: this.form.coverLetter,
                files: this.fileSingle
            };

            console.log(this.fileSingle);
            console.log(payload);
            ShopService.getProduct(payload)
                .then(response => {
                    console.log('Data saved successfully:', response);
                    this.closeModal();
                })
                .catch(error => {
                    console.error('Error saving data:', error);
                });
        },
        closeModal() {
            this.showModal = false;
        },
        extractText(text) {
            const div = document.createElement('div');
            div.innerHTML = text;
            this.extractedText = div.textContent || div.innerText;
            return this.extractedText;
        },
    },
    async mounted() {
        let productDetail = await ShopService.getProduct(this.id);
        this.product = productDetail.data;
        console.log(this.product);
        await this.$store.dispatch('user/fetchUser');
        await this.$store.dispatch('profile/fetchProfile');
        this.editedUser = this.user;
        this.editedUser.mobile = this.profile.mobile;
        setTimeout(async () => {
            this.product = productDetail.data;
        }, 1000);

    }
};
</script>
