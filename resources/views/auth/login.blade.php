@extends('layouts.app')

@section('title', 'Login - Sistema de Matrícula de Estudantes')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-center text-white">
                <i class="fas fa-graduation-cap fa-5x mb-4"></i>
                <h2 class="mb-3">Sistema de Matrícula de Estudantes</h2>
                <p class="lead">Gerencie seus estudantes de forma eficiente com nosso sistema moderno</p>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="card shadow-lg border-0" style="width: 100%; max-width: 400px;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Bem-vindo de Volta</h3>
                        <p class="text-muted">Por favor, faça login em sua conta</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>Nome de Usuário
                            </label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autofocus
                                   placeholder="Digite seu nome de usuário">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Senha
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Digite sua senha">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Entrar
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            © {{ date('Y') }} Sistema de Matrícula de Estudantes. Todos os direitos reservados.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 15px;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
    }
    .btn-primary {
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
    }
</style>
@endpush