

const loginForm = document.getElementById("loginForm");

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
    xhr.open("POST", serverPath + "includes/logout.php", true);
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
  xhr.open("POST", serverPath + "includes/logarSe.php", true);
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

function loadRichText(el) {
  tinymce.init({
      selector: el,
      height: 300,
      plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
          'bold italic backcolor | alignleft aligncenter ' +
          'alignright alignjustify | bullist numlist outdent indent | ' +
          'removeformat | help',
      content_css: '//www.tiny.cloud/css/codepen.min.css',
      language: 'pt_BR',
      setup: function (editor) {
          editor.on('change', function () {
              tinymce.triggerSave();
          });
      }
  });
}

function generateNewModule(id) {

  var moduloBox = document.createElement('div');
  moduloBox.className = 'alert alert-secondary modulobox';

  moduloBox.innerHTML = `
<div class="pb-3">Título:
  <input required type="text" class="form-control" name="modulo_title[]">
</div>
Conteúdo:
<textarea name="modulo_content[]" id="richtext` + id + `"></textarea>
<div class="text-center p-3">
  <button type="button" class="btn btn-danger deletamodulo">
      <i class="fas fa-trash"></i>Remover Módulo</button>
</div>
`;

return moduloBox;

}