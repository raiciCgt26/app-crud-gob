import { LoginService } from "../services/login.service.js";

class LoginController {
  constructor() {
    this.loginService = new LoginService();
  }

  async handleRegister(formData) {
    const result = await this.loginService.registerUser(formData);
    console.log(result);
    // Lógica para manejar la respuesta del registro
  }

  async handleLogin(formData) {
    const result = await this.loginService.loginUser(formData);
    console.log(result);
    // Lógica para manejar la respuesta del login
  }
}

export const loginController = new LoginController();
