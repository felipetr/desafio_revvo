<?php
// userDropdown

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
?>

  <div class="dropdown">
    <div class="w-100 dropdown-toggle text-center p-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <img id="avatar-header" class="avatar" src="<?php echo resizeImage(baseUrl() . '/uploads/' . $user['avatar'], 43, 43); ?>" alt="<?php echo $user['name']; ?>" title="<?php echo $user['name']; ?>">

      <div class="welcome d-none d-sm-inline-block">
        <small id="welcome-header"><?php
                if ($user['gender']) {
                  echo 'Seja bem-vind' . $user['gender'];
                } else {
                  echo 'Boas vindas';
                }
                ?></small>
        <div id="name-header"><?php echo $user['name']; ?></div>
      </div>
    </div>
    <ul class="dropdown-menu dropdown-menu-end">
      <li><a class="dropdown-item" href="<?php echo baseUrl(); ?>profile"><i class="fas fa-user"></i> Perfil</a></li>
      <li><a class="dropdown-item" href="<?php echo baseUrl(); ?>cursos/1"><i class="fas fa-graduation-cap"></i> Cursos</a></li>
      <hr>
      <li><a class="dropdown-item" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
    </ul>
  </div>

<?php
} else {
?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const storedCredentials = localStorage.getItem("loginCredentials");
      if (storedCredentials) {

        const decryptedCredentials = decryptCredentials(storedCredentials);

        if (decryptedCredentials.username && decryptedCredentials.password) {

          logarSe(decryptedCredentials.username, decryptedCredentials.password, true);

        } else {

          localStorage.removeItem("loginCredentials");
          console.error("Erro ao descriptografar credenciais salvas:", decryptedCredentials.error);

        }
      }
    })
  </script>
  <button type="button" class="btn logarsbtn" data-bs-toggle="modal" data-bs-target="#loginModal">
    Logar-se
  </button>


<?php
}
?>