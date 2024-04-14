
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="loginForm">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Logar-se</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <label for="email">Email:</label>
        <input required type="email" id="email" name="email" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Senha:</label>
        <input required type="password" id="password" name="password" class="form-control">
      </div>
      <div class="alert alert-danger" id="loginMessage" style="display: none;">
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
        <label class="form-check-label" for="rememberMe">Lembrar de mim</label>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-success">Logar-se</button>
      </div>
</form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="<?php echo distUrl(); ?>assets/js/scripts.js"></script>
</body>
</html>