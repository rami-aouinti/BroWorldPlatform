import axios from "axios";
import authHeader from "./../auth-header";

const API_URL = "http://localhost/api/v1/admin/shop/";

class ShopService {

    getTotalCategories() {
    return axios.get(API_URL + "category/count", { headers: authHeader() }).then(
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

    getTotalProducts() {
        return axios.get(API_URL + "product/count", { headers: authHeader() }).then(
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

    getTotalOrders() {
        return axios.get(API_URL + "order/count", { headers: authHeader() }).then(
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

    getCategories() {
        return axios.get(API_URL + "category", { headers: authHeader() });
    };

    getProducts() {
        return axios.get(API_URL + "product", { headers: authHeader() });
    };

    getOrders() {
        return axios.get(API_URL + "order", { headers: authHeader() });
    };

    createCategory(category) {
        return axios.post(API_URL + "category", category, { headers: authHeader() });
    };

    createProduct(product) {
        return axios.post(API_URL + "product", product, { headers: authHeader() });
    };

    createOrder(order) {
        return axios.post(API_URL + "order", order, { headers: authHeader() });
    };

    updateCategory(category) {
        return axios.put(API_URL + "category/" + category.id, category, { headers: authHeader() });
    };

    updateProduct(product) {
        return axios.put(API_URL + "product/" + product.id, product, { headers: authHeader() });
    };

    updateOrder(order) {
        return axios.put(API_URL + "order/" + order.id, order, { headers: authHeader() });
    };

    deleteCategory(category) {
        return axios.delete(API_URL + "category/" + category.id, { headers: authHeader() });
    };

    deleteProduct(product) {
        return axios.delete(API_URL + "product/" + product.id, { headers: authHeader() });
    };

    deleteOrder(order) {
        return axios.delete(API_URL + "order/" + order.id, { headers: authHeader() });
    };

}

export default new ShopService();
