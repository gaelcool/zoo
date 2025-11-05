document.addEventListener("DOMContentLoaded", () => {

  const nombre = document.getElementById("nombre");
  const correo = document.getElementById("correo");
  const clave = document.getElementById("clave");

  if (nombre && correo && clave) {
    const fields = [
      {
        input: nombre,
        validator: value => value.trim().length >= 3,
        message: "Nombre debe tener al menos 3 caracteres."
      },
      {
        input: correo,
        validator: value => /^[^\s@]+@[a-zA-Z]+$/.test(value),
        message: "Debe contener un @ seguido de letras."
      },
      {
        input: clave,
        validator: value => value.length >= 6,
        message: "Contraseña mínima de 6 caracteres."
      }
    ];

    const registerButton = document.querySelector("button[type='submit']");
    registerButton.disabled = true;
    registerButton.style.opacity = "0.6";
    registerButton.style.cursor = "not-allowed";

    const validState = { nombre: false, correo: false, clave: false };

    const updateButtonState = () => {
      const allValid = Object.values(validState).every(Boolean);
      registerButton.disabled = !allValid;
      registerButton.style.opacity = allValid ? "1" : "0.6";
      registerButton.style.cursor = allValid ? "pointer" : "not-allowed";
    };

    fields.forEach(({ input, validator, message }) => {
      const validationBox = input.parentElement.querySelector(".validation-box");

      input.addEventListener("input", () => {
        const value = input.value.trim();
        const isValid = validator(value);
        validationBox.textContent = isValid ? "Bien :)" : message;
        validationBox.classList.toggle("valid", isValid);
        validationBox.classList.toggle("Invalido :(", !isValid);
        validState[input.id] = isValid;
        updateButtonState();
      });
    });

    const form = document.querySelector("form");
    form.addEventListener("submit", e => {
      e.preventDefault();
      if (!registerButton.disabled) {
        alert("¡Registro exitoso! Redirigiendo a la página principal...");
        window.location.href = "LP.html"; // redirect to Landing Page
      }
    });
  }
