import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class ShopService {
    getProducts() {
        return axios.get(API_URL + "shop/products", { headers: authHeader() }).then(
            (response) => {
                return response
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    };
    async getCart() {
        return axios.get(API_URL + "shop/cart", { headers: authHeader() }).then(
            (response) => {
                return response.data;
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    };

    async addToCart(productId) {
        return axios.post(API_URL + "shop/add/" + productId + "/cart", {} ,{ headers: authHeader() }).then(
            (response) => {
                return response
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    };

    async decreaseItem(productId) {
        await axios.post(`${API_URL}/decrease/${productId}`);
    };

    async removeItem(productId) {
        await axios.delete(`${API_URL}/remove/${productId}`);
    };

    async clearCart() {
        await axios.delete(`${API_URL}/clear`);
    };

    getProduct(id) {
        return axios.get(API_URL + "shop/product/" + id, { headers: authHeader() }).then(
            (response) => {
                return response;
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    };
    createProduct(product) {
        return axios.post(API_URL + "shop/product", product ,{ headers: authHeader() }).then(
            (response) => {
                return response.data
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    }
}

export default new ShopService();
