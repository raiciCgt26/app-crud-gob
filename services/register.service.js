import { Model } from "./model.js";

export class RegisterService extends Model {
  async registerUser(data) {
    return this.execQuery("../php/register.php", data);
  }
}
