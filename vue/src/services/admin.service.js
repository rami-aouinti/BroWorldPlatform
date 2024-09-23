import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class UserService {

    getTotalUsers() {
    return axios.get(API_URL + "user/count", { headers: authHeader() }).then(
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

    getTotalUsersGroup() {
        return axios.get(API_URL + "user_group/count", { headers: authHeader() }).then(
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

    getTotalUsersRole() {
        return axios.get(API_URL + "role/count", { headers: authHeader() }).then(
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

    getUsers() {
        return axios.get(API_URL + "user", { headers: authHeader() });
    };

    getUsersGroup() {
        return axios.get(API_URL + "user_group", { headers: authHeader() });
    };

    getUsersRole() {
        return axios.get(API_URL + "role", { headers: authHeader() });
    };

    createUser(user) {
        return axios.post(API_URL + "user", user, { headers: authHeader() });
    };

    createUserGroup(group) {
        return axios.post(API_URL + "user_group", group, { headers: authHeader() });
    };

    createUserRole(role) {
        return axios.post(API_URL + "role", role, { headers: authHeader() });
    };

    updateUser(user) {
        return axios.put(API_URL + "user/" + user.id, user, { headers: authHeader() });
    };

    updateUserGroup(group) {
        return axios.put(API_URL + "user_group/" + group.id, group, { headers: authHeader() });
    };

    updateUserRole(role) {
        return axios.put(API_URL + "role/" + role.id, role, { headers: authHeader() });
    };

    deleteUser(user) {
        return axios.delete(API_URL + "user/" + user.id, { headers: authHeader() });
    };

    deleteUserGroup(group) {
        return axios.delete(API_URL + "user_group/" + group.id, { headers: authHeader() });
    };

    deleteUserRole(role) {
        return axios.delete(API_URL + "role/" + role.id, { headers: authHeader() });
    };

}

export default new UserService();
