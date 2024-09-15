import axios from "axios";
import authHeader from "./../auth-header";

const API_URL = "http://localhost/api/v1/";

class UserService {

  getUserBoard() {
    return axios.get(API_URL + "user", { headers: authHeader() });
  }

  uploadPhoto(photo) {
    return axios.post(
      API_URL + "user/photo",
      { photo },
      { headers: authHeader() }
    );
  }

  getModeratorBoard() {
    return axios.get(API_URL + "mod", { headers: authHeader() });
  }

  getAdminBoard() {
    return axios.get(API_URL + "admin", { headers: authHeader() });
  }

  getPlaces() {
    return axios.get(API_URL + "place", { headers: authHeader() });
  }

  getUser() {
    return axios.get(API_URL + "user", { headers: authHeader() });
  }

    getConfiguration() {
        return axios.get(API_URL + "configuration", { headers: authHeader() });
    }

    getMenu() {
        return axios.get(API_URL + "menu", { headers: authHeader() });
    }

    getProfileData() {
        return axios.get(API_URL + "profile/data", { headers: authHeader() });
    }

  updateProfile(item) {
    return axios.post(API_URL + "setting", { item }, { headers: authHeader() });
  }

  statusProfile(item) {
    return axios.post(
      API_URL + "user/activate",
      { item },
      { headers: authHeader() }
    );
  }

  changePassword(item) {
    return axios.post(
      API_URL + "user/password/update",
      { item },
      { headers: authHeader() }
    );
  }

  updateSetting(item) {
    return axios.post(
      API_URL + "user/setting",
      { item },
      { headers: authHeader() }
    );
  }

  updateLocale(item) {
    return axios.post(
        API_URL + "user/locale",
        { item },
        { headers: authHeader() }
    );
  }

  getGroups() {
    return axios.get(API_URL + "profile/groups", { headers: authHeader() });
  }

  getRoles() {
    return axios.get(API_URL + "profile/roles", { headers: authHeader() });
  }

    getConfigurations() {
        return axios.get(API_URL + "profile/configurations", { headers: authHeader() });
    }
}

export default new UserService();
