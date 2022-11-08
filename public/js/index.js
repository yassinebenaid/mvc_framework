import { FormProccessor } from "./FormProccessor.js";

let fProccessor = new FormProccessor;

let registerForm = document.querySelector(".form form[action='/register']");
fProccessor.proccessForm(registerForm, "register");

let loginForm = document.querySelector(".form form[action='/login']");
fProccessor.proccessForm(loginForm, "login");