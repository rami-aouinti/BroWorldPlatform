import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class ResumeService {

    createLanguage(language) {
        return axios.post(
            API_URL + "resume/language",
            language,
            { headers: authHeader() }
        );
    };

    createProject(project) {
        return axios.post(
            API_URL + "resume/project",
            project,
            { headers: authHeader() }
        );
    };

    createEducation(education) {
        return axios.post(
            API_URL + "resume/education",
            education,
            { headers: authHeader() }
        );
    };

    createSkill(skill) {
        return axios.post(
            API_URL + "resume/skill",
            skill,
            { headers: authHeader() }
        );
    };

    createReference(reference) {
        return axios.post(
            API_URL + "resume/reference",
            reference,
            { headers: authHeader() }
        );
    };

    createHobby(hobby) {
        return axios.post(
            API_URL + "resume/hobby",
            hobby,
            { headers: authHeader() }
        );
    };

    deleteSkill(skillId) {
        return axios.delete(API_URL + `resume/skill/${skillId}`,
            { headers: authHeader() });
    };

    updateSkill(id, skill) {
        return axios.patch(API_URL + `resume/skill/${id}`, skill,
            { headers: authHeader() });
    };

    deleteEducation(educationId) {
        return axios.delete(API_URL + `resume/education/${educationId}`,
            { headers: authHeader() });
    };

    updateEducation(id, education) {
        return axios.patch(API_URL + `resume/education/${id}`, education,
            { headers: authHeader() });
    };

    deleteHobby(hobbyId) {
        return axios.delete(API_URL + `resume/hobby/${hobbyId}`,
            { headers: authHeader() });
    };

    updateHobby(id, hobby) {
        return axios.patch(API_URL + `resume/hobby/${id}`, hobby,
            { headers: authHeader() });
    };

    deleteLanguage(languageId) {
        return axios.delete(API_URL + `resume/language/${languageId}`,
            { headers: authHeader() });
    };

    updateLanguage(id, language) {
        return axios.patch(API_URL + `resume/language/${id}`, language,
            { headers: authHeader() });
    };

    deleteReference(referenceId) {
        return axios.delete(API_URL + `resume/reference/${referenceId}`,
            { headers: authHeader() });
    };

    updateReference(id, reference) {
        return axios.patch(API_URL + `resume/reference/${id}`, reference,
            { headers: authHeader() });
    };
}

export default new ResumeService();
