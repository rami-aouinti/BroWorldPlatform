import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class NotificationService {
    getNotifications() {
        return axios.get(API_URL + "profile/notifications", { headers: authHeader() }).then(
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
    readNotifications() {
        return axios.get(API_URL + "profile/notifications/read", { headers: authHeader() }).then(
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

export default new NotificationService();
