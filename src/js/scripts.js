const loginForm = document.getElementById("loginForm");

function showFirstModal()
{
    var modalCaller = document.getElementById("modalCaller");
    modalCaller.click();
}

if (localStorage.getItem('modalShowed') === null) {
    showFirstModal();
    localStorage.setItem('modalShowed',true);
}

loginForm.addEventListener("submit", function (event) {
  event.preventDefault();

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const rememberMe = document.getElementById("rememberMe").checked;
  logarSe(email, password, rememberMe);
});

const logoutBtn = document.getElementById("logoutBtn");
if (logoutBtn) {
  logoutBtn.addEventListener("click", function (event) {
    event.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", baseUrl + "includes/logout.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          console.log("Logout efetuado com sucesso!");

          localStorage.removeItem("loginCredentials");

          window.location.href = window.location.href;
        } else {
          console.error("Erro no logout:", response.message);
        }
      } else {
        console.error("Erro na requisição AJAX:", xhr.statusText);
      }
    };

    xhr.onerror = function () {
      console.error("Erro na requisição AJAX:", xhr.statusText);
    };

    const data = JSON.stringify({});

    xhr.send(data);
  });
}
function logarSe(email, password, rememberMe) {
  document.getElementById("loginMessage").style.display = "none";

  const xhr = new XMLHttpRequest();
  xhr.open("POST", baseUrl + "includes/logarSe.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        console.log("Login efetuado com sucesso!");

        if (rememberMe) {
          const encryptedCredentials = encryptCredentials(email, password);
          localStorage.setItem("loginCredentials", encryptedCredentials);
        }

        window.location.href = window.location.href;
      } else {
        console.error("Erro no login:", response.message);
        document.getElementById("loginMessage").style.display = "block";
        document.getElementById("loginMessage").innerHTML =
          "Erro no login: " + response.message;
      }
    } else {
      console.error("Erro na requisição AJAX:", xhr.statusText);
      document.getElementById("loginMessage").style.display = "block";
      document.getElementById("loginMessage").innerHTML =
        "Erro no servidor. Tente novamente mais tarde.";
    }
  };

  xhr.onerror = function () {
    console.error("Erro na requisição AJAX:", xhr.statusText);
    document.getElementById("loginMessage").innerHTML =
      "Erro no servidor. Tente novamente mais tarde.";
  };

  const data = `email=${email}&password=${password}`;

  xhr.send(data);
}

function encryptCredentials(email, password) {
  const encodedEmail = btoa(email);
  const encodedPassword = btoa(password);

  const reversedEmail = encodedEmail.split("").reverse().join("");
  const reversedPassword = encodedPassword.split("").reverse().join("");

  return reversedEmail + ":" + reversedPassword;
}

function decryptCredentials(encryptedCredentials) {
  const [reversedEmail, reversedPassword] = encryptedCredentials.split(":");

  const encodedEmail = reversedEmail.split("").reverse().join("");
  const encodedPassword = reversedPassword.split("").reverse().join("");

  const email = atob(encodedEmail);
  const password = atob(encodedPassword);

  return { email, password };
}
