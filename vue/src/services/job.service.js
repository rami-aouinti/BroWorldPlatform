import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class JobService {

    createJob(job) {
        return axios.post(
            API_URL + "job",
            job,
            { headers: authHeader() }
        );
    };

    getJobs() {
        return axios.get(API_URL + "jobs", { headers: authHeader() }).then(
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
    };

    getJob(id) {
        return axios.get(API_URL + "job/" + id, { headers: authHeader() }).then(
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
    getFilteredJobs(searchFilter) {
        return axios.post(API_URL + "jobs/search", searchFilter ,{ headers: authHeader() }).then(
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
    };

    setApplication(application) {
        return axios.post(
            API_URL + "jobs_applications/" + application.job,
            application,
            { headers: authHeader() }
        );
    };
}

export default new JobService();
