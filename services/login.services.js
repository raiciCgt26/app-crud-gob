import { Model } from "./model.js";

export class LoginService extends Model {
  async registerUser(data) {
    return this.execQuery("../php/register.php", data);
  }

  async loginUser(data) {
    return this.execQuery("../php/login.php", data);
  }
}

export const loginService = new LoginService();
