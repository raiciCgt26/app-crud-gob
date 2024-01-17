import React from "react";
import "../css/login-signup.css";

function Login() {
  return (
    <div>
      <div class="container">
        <div id="register" class="container-form register">
          <div class="information">
            <div class="info-childs">
              <img class="icono" src="/aseets/img/logo-round.jpg" alt="" />
              <h2>Bienvenido al Sistema de incidencias</h2>
              <p>Para ingresar inicie sesion con su correo y contraseña</p>
              <input
                class="btn-login"
                id="sign-in"
                type="button"
                value="iniciar sesion"
              />
            </div>
          </div>
          <div class="form-information">
            <div class="form-information-childs">
              <h2>Crear una cuenta</h2>
              <div class="icons">
                <form class="form">
                  <label for>
                    <img src="frontend/aseets/icons/person-check.svg" alt="" />
                    <input
                      type="text"
                      placeholder="Nombre Completo"
                      id="register"
                    />
                  </label>

                  <label for>
                    <img src="/aseets/icons/bx-user.svg" alt="" />
                    <input
                      type="text"
                      placeholder="Usuario"
                      name="username"
                      required
                    />
                  </label>
                  <label for>
                    <img src="/aseets/icons/bx-envelope.svg" alt="" />
                    <input type="email" placeholder="Email" id="email" />
                  </label>

                  <label for>
                    <img src="/aseets/icons/bx-lock-alt.svg" alt="" />
                    <input
                      type="password"
                      placeholder="Escribe tu contraseña"
                      id="password-reg"
                    />
                  </label>
                  <input class="btn-login" type="submit" value="Registrarse" />
                </form>
              </div>
            </div>
          </div>
        </div>

        <div id="login" class="container-form login hide">
          <div class="information">
            <div class="info-childs">
              <img class="icono" src="/aseets/img/logo-round.jpg" alt="" />
              <h2>Bienvenido de nuevo al Sistema de incidencias</h2>
              <p>Si no tienes una cuenta puedes registrarte</p>
              <input
                class="btn-login"
                id="sign-up"
                type="button"
                value="Registrarse"
              />
            </div>
          </div>
          <div class="form-information">
            <div class="form-information-childs">
              <h2>Iniciar sesion</h2>
              <div class="icons">
                <form id="loginFom" class="form">
                  <label for>
                    <img src="/aseets/icons/bx-user.svg" alt="" />
                    <input
                      type="text"
                      placeholder="Usuario"
                      name="username"
                      id="login"
                      required
                    />
                  </label>

                  <label for>
                    <img src="/aseets/icons/bx-lock-alt.svg" alt="" />
                    <input
                      type="password"
                      placeholder="Escribe tu contraseña"
                      name="password"
                      id="password-log"
                      required
                    />
                  </label>
                  <input
                    class="btn-login"
                    type="submit"
                    value="Iniciar sesion"
                  />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Login;
