<?php
// profilePage

checkLogin();

?>

<div class="container py-5">
    <h1 class="title-page medium-gray-color toUpper">// MEU PERFIL</h1>
    <hr class="separator">

    <?php
    $imagesize = array(
        'width' => 100,
        'height' => 100,
        'target' => 'avatarbox'
    );
    getModule('ImageUploadModal', $imagesize);
    $user = $_SESSION['user'];
    ?>
    <form id="updateProfileForm" class="pb-3">
        <h2 class="title-page medium-gray-color toUpper">// DADOS</h2>
        <div class="row">

            <div class="col-12 col-md-2 text-center">

                <div id="avatarbox">
                    <div>
                        <input name="avatar" type="hidden" id="imgUrl" class="imgUrl" value="<?php echo $user['avatar']; ?>">
                    </div>
                    <img id="avatar-profile" class="avatar-profile loader imgCropped" src="<?php echo resizeImage(baseUrl() . 'uploads/' . $user['avatar'], 100, 100) ?>" alt="avatar">

                </div>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#imageUploadModal"> Mudar Avatar </button>
            </div>
            <div class="col text-center">
                <div class="alert alert-secondary text-start">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label for="nome" class="form-label medium-gray-color"><b>Nome<small class="text-danger">*</small>:</b></label>
                            <input placeholder="Digite seu nome..." value="<?php echo $user['name']; ?>" type="text" required class="form-control" id="nome" name="name">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label medium-gray-color"><b>Email:</b></label>
                            <span class="form-control form-control-disabled"><?php echo $user['email']; ?></span>
                        </div>

                    </div>
                    <hr>
                    <div>
                        <label for="gender" class="form-label medium-gray-color"><b>Gênero:</b></label>
                    </div>
                    <div class="alert alert-light d-inline-block">
                        <input type="radio" value="a" class="btn-check" name="gender" id="option1" autocomplete="off" <?php
                                                                                                                        if ($user['gender'] == 'a') {
                                                                                                                            echo ' checked';
                                                                                                                        }
                                                                                                                        ?>>
                        <label class="btn btn-outline-dark" for="option1">Feminino</label>

                        <input type="radio" value="o" class="btn-check" name="gender" id="option2" autocomplete="off" <?php
                                                                                                                        if ($user['gender'] == 'o') {
                                                                                                                            echo ' checked';
                                                                                                                        }
                                                                                                                        ?>>
                        <label class="btn btn-outline-dark" for="option2">Masculino</label>


                        <input type="radio" value="" class="btn-check" name="gender" id="option3" autocomplete="off" <?php
                                                                                                                        if (!$user['gender']) {
                                                                                                                            echo 'checked';
                                                                                                                        }
                                                                                                                        ?>>
                        <label class="btn btn-outline-dark" for="option3">Neutro</label>
                    </div>
                    <hr>
                    <div id="profilemsg">

                    </div>
                    <button class="btn btn-dark d-block w-100">Salvar</button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <form id="updatePassForm" class="pb-3">
        <h2 class="title-page medium-gray-color toUpper">// ALTERAR SENHA</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <label for="pass" class="form-label medium-gray-color"><b>Senha<small class="text-danger">*</small>:</b></label>
                <input placeholder="Digite a senha..." value="" type="password" required class="form-control" id="pass" name="pass">

            </div>
            <div class="col-12 col-md-6">
                <label for="pass2" class="form-label medium-gray-color"><b>Confirme a Senha<small class="text-danger">*</small>:</b></label>
                <input placeholder="Digite a senha..." value="" type="password" required class="form-control" id="pass2" name="pass2">

            </div>
        </div>
        <div id="passmsg">

        </div>
        <button class="btn btn-dark d-block w-100">Salvar</button>
    </form>
    <div class="alert alert-secondary">
        <pre><?php echo json_encode($user, JSON_PRETTY_PRINT); ?></pre>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateProfileForm = document.getElementById("updateProfileForm");
        const profilemsg = document.getElementById("profilemsg");

        updateProfileForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(updateProfileForm);
            
            if(formData.pass != formData.pass2)
            {
                profilemsg.innerHTML = '<div class="alert alert-warning">Senhas nao coincidem!</div>';
                exit;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', serverPath + "includes/profile/updateProfile.php", true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        profilemsg.innerHTML = '<div class="alert alert-success">Mensagem salva com sucesso!</div>';

                        var wcMsg = 'Boas vindas';
                        if (response.data.gender) {
                            wcMsg = "Seja bem-vind" + response.data.gender;
                        }
                        const welcomeheader = document.getElementById("welcome-header");
                        welcomeheader.innerHTML = wcMsg;
                        if (response.data.avatar) {
                            const avatarheader = document.getElementById("avatar-header");
                            const avatarprofile = document.getElementById("avatar-profile");
                            avatarheader.src = avatarprofile.src;
                        }
                        if (response.data.name) {
                            const nameheader = document.getElementById("name-header");
                            nameheader.innerHTML = response.data.name;
                        }


                    } else {
                        profilemsg.innerHTML = '<div class="alert alert-danger">' + response.msg + '</div>';
                    }
                } else {
                    profilemsg.innerHTML = '<div class="alert alert-danger">Erro ao salvar dados</div>';
                }
            };
            xhr.send(formData);
        });

        const updatePassForm = document.getElementById("updatePassForm");
        const passmsg = document.getElementById("passmsg");

        updatePassForm.addEventListener("submit", function(event) {
            event.preventDefault();



            const formData = new FormData(updatePassForm);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', serverPath + "includes/profile/updatePass.php", true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        profilemsg.innerHTML = '<div class="alert alert-success">SEnha salva com sucesso!</div>';
                        const storedCredentials = localStorage.getItem("loginCredentials");
                        if (storedCredentials) {
                            const decryptedCredentials = decryptCredentials(storedCredentials);
                            var usermail = decryptedCredentials.username;
                            var pass = formData.pass;

                            var newCredentials = encryptCredentials(email, pass);
                            localStorage.setItem("loginCredentials", newCredentials);

                        }

                    } else {
                        passmsg.innerHTML = '<div class="alert alert-danger">' + response.msg + '</div>';
                    }
                } else {
                    passmsg.innerHTML = '<div class="alert alert-danger">Erro ao salvar senha</div>';
                }
            };
            xhr.send(formData);
        });
    });
</script>