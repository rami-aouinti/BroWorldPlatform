import axios from "axios";
import authHeader from "./auth-header";
import {configuration} from "../store/configuration.module";

const API_URL = "http://localhost/api/v1/";

class BlogService {

    getPosts() {
        return axios.get(API_URL + "blog/post", { headers: authHeader() }).then(
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
    }

    async addComment(post, content) {
        return await axios.post(API_URL + "blog/post/comment/" + post, {'content': content}, {headers: authHeader()});
    }

    async likePost(post) {
        return await axios.post(API_URL + "post/" + post + "/like", {}, {headers: authHeader()});
    }

    async likeComment(comment) {
        return await axios.post(API_URL + "comment/" + comment + "/like", {}, {headers: authHeader()});
    }
}

export default new BlogService();
