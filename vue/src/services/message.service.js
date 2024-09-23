import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class MessageService {

  getMessages(receiver) {
    return axios.get(API_URL + "message/" + receiver, { headers: authHeader() });
  }

  async addMessage(content, receiver) {
      return await axios.post(API_URL + "message/" + receiver, { 'content': content }, {headers: authHeader()}
      );
  }

}

export default new MessageService();
