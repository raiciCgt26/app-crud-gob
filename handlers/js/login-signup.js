const btnSignIn = document.getElementById("sign-in"),
  btnSignUp = document.getElementById("sign-up"),
  formRegister = document.getElementById("register"),
  formLogin = document.getElementById("login");

btnSignIn.addEventListener("click", (e) => {
  formRegister.classList.add("hide");
  formLogin.classList.remove("hide");
});
btnSignUp.addEventListener("click", (e) => {
  formLogin.classList.add("hide");
  formRegister.classList.remove("hide");
});
