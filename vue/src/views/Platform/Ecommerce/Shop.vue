<template>
    <div>
        <!-- Bouton pour ouvrir le modal -->
        <v-btn @click="dialog = true">Add Product</v-btn>

        <v-btn
            @click="goToNewProductPage"
        >
            New Product
        </v-btn>

        <!-- Modal avec le formulaire -->
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-card-title>Add New Product</v-card-title>

                <v-card-text>
                    <v-form ref="form">
                        <v-text-field v-model="productForm.name" label="Product Name" required rounded outlined dense></v-text-field>
                        <v-text-field v-model="productForm.subtitle" label="Subtitle" rounded outlined dense></v-text-field>
                        <v-textarea v-model="productForm.description" label="Description" rounded outlined dense></v-textarea>
                        <v-text-field v-model="productForm.price" label="Price" required rounded outlined dense></v-text-field>
                        <v-text-field v-model="productForm.category" label="Category" rounded outlined dense></v-text-field>
                        <dropzone class="my-dropzone" v-model="files" multiple rounded outlined dense></dropzone>
                        <v-switch v-model="productForm.isInHome" label="Featured in Home"></v-switch>
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="submitForm">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-row v-if="products.length > 0" class="mb-6 mt-10">
            <v-col
                v-for="(item, i) in products"
                :key="item.name + i"
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
                                :to="{ name: 'ProductDetail', params: { id: item.id } }"
                                class="text-decoration-none"
                            >
                                <img
                                    :src="'http://localhost/'+ item.medias[0].path +'/' + item.image"
                                    class="img-fluid shadow border-radius-lg"
                                    :alt="item.image"
                                />
                            </router-link>
                        </div>
                        <div
                            class="colored-shadow"
                            v-bind:style="{ backgroundImage: 'url(' + 'http://localhost/uploads/' + item.image + ')' }"
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
                            :to="{ name: 'ProductDetail', params: { id: item.id } }"
                            class="text-decoration-none text-default"
                        >
                            {{ item.name }}
                        </router-link>
                    </h5>

                    <p class="mb-0 text-body font-weight-light px-5">
                        {{ item.subtitle }}
                    </p>
                    <hr class="horizontal dark my-6" />
                    <div class="d-flex text-body mx-2 px-4">
                        <p class="mb-0 font-weight-normal text-body">
                            {{ item.subtitle }}
                        </p>
                        <v-btn
                            @click="addToCart(item.id)"
                        >
                            Add
                        </v-btn>
                        <i class="material-icons-round position-relative ms-auto text-lg me-1 my-auto">
                            place
                        </i>
                        <p class="text-sm my-auto font-weight-light">
                            {{ item.price }}
                        </p>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>

</template>

<script>
import Dropzone from "../Job/Job/Widgets/MediaDropzone.vue";
import ShopService from "../../../services/shop.service";
import {mapGetters} from "vuex";

export default {
    name: 'Shop',
    components: {Dropzone},
    data() {
        return {
            dialog: false,
            productForm: {
                name: '',
                subtitle: '',
                description: '',
                price: null,
                category: '',
                isInHome: false,
                image: ''
            },
            files: [],
            products: []
        };
    },
    methods: {
        async submitForm() {
            const formData = new FormData();
            formData.append('name', this.productForm.name);
            formData.append('subtitle', this.productForm.subtitle);
            formData.append('description', this.productForm.description);
            formData.append('price', this.productForm.price);
            formData.append('category', this.productForm.category);
            formData.append('isInHome', this.productForm.isInHome);
            formData.append('image', '');


            this.files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            try {

                const response = await ShopService.createProduct(formData);
                if (response.ok) {
                    console.log('Product created successfully');
                    this.dialog = false;
                } else {
                    console.error('Failed to create product');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },
        goToNewProductPage() {
            this.$router.push({ name: 'newProduct' });
        },
        async addToCart(productId) {
            await ShopService.addToCart(productId);
        },
    },
    computed: {
        ...mapGetters('user', ['user']),
        ...mapGetters('product', ['product'])
    },
    created() {
        this.$store.dispatch('product/fetchProducts');
        this.$store.dispatch('user/fetchUser');
        this.products = this.product;
    },
    mounted() {
        setTimeout(() => {
            this.$store.dispatch('user/fetchUser');
            this.$store.dispatch('product/fetchProducts');
            this.products = this.product;
            this.$store.dispatch('user/fetchUser');
        }, 1000);
    }
};
</script>
