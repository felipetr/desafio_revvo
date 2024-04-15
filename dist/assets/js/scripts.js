const loginForm=document.getElementById("loginForm"),logoutBtn=(loginForm.addEventListener("submit",function(e){e.preventDefault(),logarSe(document.getElementById("email").value,document.getElementById("password").value,document.getElementById("rememberMe").checked)}),document.getElementById("logoutBtn"));function logarSe(o,n,r){document.getElementById("loginMessage").style.display="none";const s=new XMLHttpRequest;s.open("POST",serverPath+"includes/logarSe.php",!0),s.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),s.onload=function(){var e,t;200===s.status?(e=JSON.parse(s.responseText)).success?(console.log("Login efetuado com sucesso!"),r&&(t=encryptCredentials(o,n),localStorage.setItem("loginCredentials",t)),window.location.href=window.location.href):(console.error("Erro no login:",e.message),document.getElementById("loginMessage").style.display="block",document.getElementById("loginMessage").innerHTML="Erro no login: "+e.message):(console.error("Erro na requisição AJAX:",s.statusText),document.getElementById("loginMessage").style.display="block",document.getElementById("loginMessage").innerHTML="Erro no servidor. Tente novamente mais tarde.")},s.onerror=function(){console.error("Erro na requisição AJAX:",s.statusText),document.getElementById("loginMessage").innerHTML="Erro no servidor. Tente novamente mais tarde."},s.send(`email=${o}&password=`+n)}function encryptCredentials(e,t){e=btoa(e),t=btoa(t);return e.split("").reverse().join("")+":"+t.split("").reverse().join("")}function decryptCredentials(e){var[e,t]=e.split(":"),e=e.split("").reverse().join(""),t=t.split("").reverse().join("");return{email:atob(e),password:atob(t)}}function loadRichText(e){tinymce.init({selector:e,height:300,plugins:["advlist autolink lists link image charmap print preview anchor","searchreplace visualblocks code fullscreen","insertdatetime media table paste code help wordcount"],toolbar:"undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help",content_css:"//www.tiny.cloud/css/codepen.min.css",language:"pt_BR",setup:function(e){e.on("change",function(){tinymce.triggerSave()})}})}function generateNewModule(e){var t=document.createElement("div");return t.className="alert alert-secondary modulobox",t.innerHTML=`
<div class="pb-3">Título:
  <input required type="text" class="form-control" name="modulo_title[]">
</div>
Conteúdo:
<textarea name="modulo_content[]" id="richtext`+e+`"></textarea>
<div class="text-center p-3">
  <button type="button" class="btn btn-danger deletamodulo">
      <i class="fas fa-trash"></i>Remover Módulo</button>
</div>
`,t}logoutBtn&&logoutBtn.addEventListener("click",function(e){e.preventDefault();const t=new XMLHttpRequest;t.open("POST",serverPath+"includes/logout.php",!0),t.setRequestHeader("Content-Type","application/json"),t.onload=function(){var e;200===t.status?(e=JSON.parse(t.responseText)).success?(console.log("Logout efetuado com sucesso!"),localStorage.removeItem("loginCredentials"),window.location.href=window.location.href):console.error("Erro no logout:",e.message):console.error("Erro na requisição AJAX:",t.statusText)},t.onerror=function(){console.error("Erro na requisição AJAX:",t.statusText)};e=JSON.stringify({});t.send(e)});