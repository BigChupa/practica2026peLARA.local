@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-edit"></i> Редагування профілю</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3" id="profile-section">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>Основна інформація</div>
                            <div>
                                <button id="edit-name-btn" class="btn btn-sm btn-outline-primary">Змінити нікнейм</button>
                                <button id="edit-email-btn" class="btn btn-sm btn-outline-secondary">Змінити email</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="profile-form" action="{{ route('users.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="profile">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Ім'я</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" disabled required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" disabled required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button id="save-profile-btn" type="submit" class="btn btn-warning" disabled><i class="fas fa-save"></i> Зберегти</button>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">Скасувати</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-3" id="password-section">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>Змінити пароль</div>
                            <div>
                                <button id="toggle-password-form" class="btn btn-sm btn-outline-primary">Показати форму зміни пароля</button>
                            </div>
                        </div>
                        <div class="card-body" id="password-body" style="display:none">
                            <form id="password-form" action="{{ route('users.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="password">
                                <div class="mb-3">
                                    <label class="form-label">Новий пароль</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Підтвердження пароля</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <div>
                                    <button class="btn btn-primary">Оновити пароль</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3" id="avatar-section">
                        <div class="card-header">Аватар</div>
                        <div class="card-body text-center">
                            @if($user->avatar)
                                <img src="/{{ 'storage/app/public/' . $user->avatar }}" alt="avatar" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover">
                            @else
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}?s=120&d=mp" alt="avatar" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover">
                            @endif

                            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="avatar">
                                <div class="mb-3">
                                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                                    @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="delete_avatar" value="1" id="deleteAvatar">
                                    <label class="form-check-label" for="deleteAvatar">Видалити поточний аватар</label>
                                </div>

                                <div>
                                    <button class="btn btn-success">Оновити аватар</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function(){
                // enable name editing
                const editNameBtn = document.getElementById('edit-name-btn');
                const editEmailBtn = document.getElementById('edit-email-btn');
                const nameInput = document.getElementById('name');
                const emailInput = document.getElementById('email');
                const saveProfileBtn = document.getElementById('save-profile-btn');

                editNameBtn?.addEventListener('click', function(e){
                    e.preventDefault();
                    nameInput.disabled = false;
                    nameInput.focus();
                    saveProfileBtn.disabled = false;
                });

                editEmailBtn?.addEventListener('click', function(e){
                    e.preventDefault();
                    emailInput.disabled = false;
                    emailInput.focus();
                    saveProfileBtn.disabled = false;
                });

                // toggle password form
                const togglePass = document.getElementById('toggle-password-form');
                const passBody = document.getElementById('password-body');
                togglePass?.addEventListener('click', function(e){
                    e.preventDefault();
                    if(passBody.style.display === 'none'){
                        passBody.style.display = 'block';
                        togglePass.textContent = 'Сховати форму зміни пароля';
                    } else {
                        passBody.style.display = 'none';
                        togglePass.textContent = 'Показати форму зміни пароля';
                    }
                });
            });
            </script>
            @endpush
        </div>
    </div>
</div>
@endsection
