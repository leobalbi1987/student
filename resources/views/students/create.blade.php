@extends('layouts.app')

@section('title', 'Adicionar Novo Estudante - Sistema de Matrícula de Estudantes')
@section('page-title', 'Adicionar Novo Estudante')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus me-2"></i>Formulário de Cadastro de Estudante
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" id="studentForm">
                    @csrf
                    
                    <div class="row">
                        <!-- Student Photo -->
                        <div class="col-md-12 mb-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <img id="photoPreview" 
                                         src="{{ asset('images/default-avatar.svg') }}" 
                                         alt="Foto do Estudante" 
                                         class="rounded-circle border" 
                                         style="width: 120px; height: 120px; object-fit: cover; background-color: #f8f9fa;">
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto do Estudante</label>
                                    <input type="file" 
                                           class="form-control @error('photo') is-invalid @enderror" 
                                           id="photo" 
                                           name="photo" 
                                           accept="image/*"
                                           onchange="previewPhoto(this)">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Envie uma foto nítida (JPG, PNG, GIF - Máx: 2MB)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Student Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Digite o nome completo do estudante"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Roll Number -->
                        <div class="col-md-6 mb-3">
                            <label for="roll" class="form-label">Número de Matrícula <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('roll') is-invalid @enderror" 
                                   id="roll" 
                                   name="roll" 
                                   value="{{ old('roll') }}" 
                                   placeholder="Digite o número de matrícula"
                                   required>
                            @error('roll')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Class -->
                        <div class="col-md-6 mb-3">
                            <label for="class" class="form-label">Turma <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('class') is-invalid @enderror" 
                                   id="class" 
                                   name="class" 
                                   value="{{ old('class') }}" 
                                   placeholder="ex: 1º Ano, Ciência da Computação"
                                   required>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- City -->
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Cidade <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('city') is-invalid @enderror" 
                                   id="city" 
                                   name="city" 
                                   value="{{ old('city') }}" 
                                   placeholder="Digite o nome da cidade"
                                   required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Parent Contact -->
                        <div class="col-md-12 mb-4">
                            <label for="pcontact" class="form-label">Contato dos Pais/Responsável <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('pcontact') is-invalid @enderror" 
                                   id="pcontact" 
                                   name="pcontact" 
                                   value="{{ old('pcontact') }}" 
                                   placeholder="Digite o telefone dos pais/responsável"
                                   required>
                            @error('pcontact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar aos Estudantes
                                </a>
                                <div>
                                    <button type="reset" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-undo me-2"></i>Limpar Formulário
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Adicionar Estudante
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('photoPreview').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Form validation
    document.getElementById('studentForm').addEventListener('submit', function(e) {
        const requiredFields = ['name', 'roll', 'class', 'city', 'pcontact'];
        let isValid = true;
        
        requiredFields.forEach(function(fieldName) {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });
    
    // Remove validation errors on input
    document.querySelectorAll('input').forEach(function(input) {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .text-danger {
        font-size: 0.875rem;
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    
    #photoPreview {
        border: 3px dashed #dee2e6;
        transition: all 0.3s ease;
    }
    
    #photoPreview:hover {
        border-color: #4e73df;
    }
</style>
@endpush