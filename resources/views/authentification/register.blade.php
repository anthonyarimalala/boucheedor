<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Inscription</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom :</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact :</label>
                            <input type="text" id="contact" name="contact" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="email" id="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="role">Role :</label>
                            <select id="role"  name="role" class="form-control">
                                <option value="user">user</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe :</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmation du mot de passe :</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
