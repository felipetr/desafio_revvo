function showFirstModal(){document.getElementById("modalCaller").click()}null===localStorage.getItem("modalShowed")&&(showFirstModal(),localStorage.setItem("modalShowed",!0));const loginForm=document.getElementById("loginForm"),logoutBtn=(loginForm.addEventListener("submit",function(e){e.preventDefault(),logarSe(document.getElementById("email").value,document.getElementById("password").value,document.getElementById("rememberMe").checked)}),document.getElementById("logoutBtn"));function logarSe(t,n,r){document.getElementById("loginMessage").style.display="none";const s=new XMLHttpRequest;s.open("POST",serverPath+"includes/logarSe.php",!0),s.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),s.onload=function(){var e,o;200===s.status?(e=JSON.parse(s.responseText)).success?(console.log("Login efetuado com sucesso!"),r&&(o=encryptCredentials(t,n),localStorage.setItem("loginCredentials",o)),window.location.href=window.location.href):(console.error("Erro no login:",e.message),document.getElementById("loginMessage").style.display="block",document.getElementById("loginMessage").innerHTML="Erro no login: "+e.message):(console.error("Erro na requisição AJAX:",s.statusText),document.getElementById("loginMessage").style.display="block",document.getElementById("loginMessage").innerHTML="Erro no servidor. Tente novamente mais tarde.")},s.onerror=function(){console.error("Erro na requisição AJAX:",s.statusText),document.getElementById("loginMessage").innerHTML="Erro no servidor. Tente novamente mais tarde."},s.send(`email=${t}&password=`+n)}function encryptCredentials(e,o){e=btoa(e),o=btoa(o);return e.split("").reverse().join("")+":"+o.split("").reverse().join("")}function decryptCredentials(e){var[e,o]=e.split(":"),e=e.split("").reverse().join(""),o=o.split("").reverse().join("");return{email:atob(e),password:atob(o)}}logoutBtn&&logoutBtn.addEventListener("click",function(e){e.preventDefault();const o=new XMLHttpRequest;o.open("POST",serverPath+"includes/logout.php",!0),o.setRequestHeader("Content-Type","application/json"),o.onload=function(){var e;200===o.status?(e=JSON.parse(o.responseText)).success?(console.log("Logout efetuado com sucesso!"),localStorage.removeItem("loginCredentials"),window.location.href=window.location.href):console.error("Erro no logout:",e.message):console.error("Erro na requisição AJAX:",o.statusText)},o.onerror=function(){console.error("Erro na requisição AJAX:",o.statusText)};e=JSON.stringify({});o.send(e)});