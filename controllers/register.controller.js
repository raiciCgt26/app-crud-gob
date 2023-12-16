import { RegisterService } from "../services/register.services.js";

class RegisterController {
  constructor() {
    this.registerService = new RegisterService();
  }

  async handleRegister(formData) {
    const result = await this.registerService.registerUser(formData);
    console.log(result);
    // Lógica para manejar la respuesta del registro
  }
}

export const registerController = new RegisterController();
