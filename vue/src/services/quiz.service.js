import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class QuizService {
    getQuestions(category, difficulty) {
        return axios.get(API_URL + "quiz/" + category + "/" + difficulty, { headers: authHeader() }).then(
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

    setScore(quiz, score) {
        return axios.post(API_URL + "score/" + quiz + "/" + score, {},{ headers: authHeader() }).then(
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
}

export default new QuizService();
