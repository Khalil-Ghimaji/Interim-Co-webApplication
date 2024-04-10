<h1 class="text-center">Bienvenue sur InterimCo</h1>
<p class="text-center">Connectez-vous</p>
<form method="POST" class="col-md-6 mx-auto border p-4">
    <div class="mb-3">
        <label for="username" class="form-label ">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" class="form-control <?=$formErrors?'is-invalid':'';?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control <?=$formErrors?'is-invalid':'';?>" required>
        <div class="invalid-feedback mb-3">
            <?php echo $formErrors;?>
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </div>
</form>
