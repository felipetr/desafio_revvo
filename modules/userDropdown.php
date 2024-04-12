<?php if(isset($_SESSION['user']))
{
    ?>
    <button type="button" class="btn logarsbtn d-block" id="logoutBtn">
        Sair
    </button>
    <?php
} else
{
    ?>
    <script>
        const storedCredentials = localStorage.getItem("loginCredentials");
  if (storedCredentials) {

    const decryptedCredentials = decryptCredentials(storedCredentials, encryptionKey); 

    if (decryptedCredentials.username && decryptedCredentials.password) {

      logarSe(decryptedCredentials.username, decryptedCredentials.password, true);

    } else {

      console.error("Erro ao descriptografar credenciais salvas:", decryptedCredentials.error);

    }
  }
        </script>
    <button type="button" class="btn logarsbtn  d-block" data-bs-toggle="modal" data-bs-target="#loginModal">
        Logar-se
    </button>

    
    <?php
}
?>