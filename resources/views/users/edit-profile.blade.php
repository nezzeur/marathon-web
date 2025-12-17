@extends('layout.app')

@section('contenu')
    <div class="edit-profile-container">
        <h1>Modifier mon profil</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Erreurs :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="avatar">Avatar :</label>
                @if($user->avatar)
                    <div class="current-avatar">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar actuel" class="avatar-preview">
                        <p class="text-muted">Avatar actuel</p>
                    </div>
                @endif
                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="form-control">
                <small class="form-text">Formats acceptés : JPEG, PNG, GIF, WebP (max 2 Mo)</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="{{ route('user.me') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    <style>
        .edit-profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .edit-profile-container h1 {
            margin-bottom: 30px;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-danger ul {
            margin: 10px 0 0 20px;
            padding: 0;
        }

        .alert-danger li {
            margin: 5px 0;
        }

        .edit-form {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .current-avatar {
            margin-bottom: 15px;
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0066cc;
        }

        .text-muted {
            color: #999;
            font-size: 0.9em;
            margin-top: 8px;
        }

        .form-text {
            display: block;
            margin-top: 8px;
            color: #666;
            font-size: 0.9em;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }

        .btn-primary {
            background: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #0052a3;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
@endsection

