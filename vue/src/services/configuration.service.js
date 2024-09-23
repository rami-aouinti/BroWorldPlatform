import axios from "axios";
import authHeader from "./auth-header";
import {configuration} from "../store/configuration.module";

const API_URL = "http://localhost/api/v1/";

class ConfigurationService {
    getConfigurations() {
        return axios.get(API_URL + "profile/configurations", { headers: authHeader() }).then(
            (response) => {
                return this.parseConfigurations(response.data)
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    }

    updateConfiguration(item, id) {
        return axios.put(API_URL + "configuration/" + id, {
            configurationKey: item.configurationKey,
            configurationEntry: item.configurationEntry },
            { headers: authHeader() });
    }

    parseConfigurations(configArray) {
      let configuration = [];
        configArray.forEach(config => {
            if (config.configurationKey === 'title') {
                configuration.title = config.configurationEntry || 'BroWorld';
            }
            if (config.configurationKey === 'sidebarTheme') {
                configuration.sidebarTheme = config.configurationEntry || 'dark';
            }
            if (config.configurationKey === 'sidebarColor') {
                configuration.sidebarColor = config.configurationEntry || 'success';
            }
            if (config.configurationKey === 'navbarFixed') {
                configuration.navbarFixed = config.configurationEntry || false;
            }
        });

        return configuration;
    }
}

export default new ConfigurationService();
