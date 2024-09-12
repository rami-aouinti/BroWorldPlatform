import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class ConfigurationService {

  updateLocale(item) {
    return axios.post(
        API_URL + "user/locale",
        { item },
        { headers: authHeader() }
    );
  }


    getConfigurations() {
        return axios.get(API_URL + "profile/configurations", { headers: authHeader() });
    }

    updateConfiguration(item, id) {
      console.log(item);
        return axios.put(API_URL + "configuration/" + id, {
            configurationKey: item.configurationKey,
            configurationEntry: item.configurationEntry },
            { headers: authHeader() });
    }
}

export default new ConfigurationService();
