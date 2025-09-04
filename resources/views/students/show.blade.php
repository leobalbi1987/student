@extends('layouts.app')

@section('title', $student->name . ' - Detalhes do Estudante')
@section('page-title', 'Detalhes do Estudante')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Student Photo Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>Foto do Estudante
                </h6>
            </div>
            <div class="card-body text-center">
                @if($student->photo)
                    <img src="{{ asset('storage/students/' . $student->photo) }}" 
                         alt="{{ $student->name }}" 
                         class="img-fluid rounded-circle mb-3" 
                         style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #e3e6f0;">
                @else
                    <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                         style="width: 200px; height: 200px; border: 4px solid #e3e6f0;">
                        <i class="fas fa-user fa-5x text-white"></i>
                    </div>
                @endif
                <h5 class="font-weight-bold text-gray-800">{{ $student->name }}</h5>
                <p class="text-muted mb-0">Matrícula: <span class="badge bg-primary">{{ $student->roll }}</span></p>
            </div>
        </div>
        
        <!-- Quick Actions Card -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-cogs me-2"></i>Ações Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar Estudante
                    </a>
                    <button type="button" 
                            class="btn btn-danger" 
                            onclick="confirmDelete({{ $student->id }}, '{{ $student->name }}')">
                        <i class="fas fa-trash me-2"></i>Excluir Estudante
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar aos Estudantes
                    </a>
                </div>
                
                <!-- Hidden delete form -->
                <form id="delete-form-{{ $student->id }}" 
                      action="{{ route('students.destroy', $student) }}" 
                      method="POST" 
                      style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Student Information Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informações do Estudante
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Nome Completo:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">{{ $student->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Número de Matrícula:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            <span class="badge bg-primary fs-6">{{ $student->roll }}</span>
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Turma:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">{{ $student->class }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Cidade:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $student->city }}
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Contato dos Pais/Responsável:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            <i class="fas fa-phone text-success me-2"></i>
                            <a href="tel:{{ $student->pcontact }}" class="text-decoration-none">{{ $student->pcontact }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Registration Details Card -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>Detalhes do Cadastro
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Data de Cadastro:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            <i class="fas fa-calendar-plus text-info me-2"></i>
                            {{ $student->created_at->format('d/m/Y') }}
                            <small class="text-muted d-block">{{ $student->created_at->format('H:i') }}</small>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-gray-700">Última Atualização:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            <i class="fas fa-edit text-warning me-2"></i>
                            {{ $student->updated_at->format('d/m/Y') }}
                            <small class="text-muted d-block">{{ $student->updated_at->format('H:i') }}</small>
                        </p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label font-weight-bold text-gray-700">ID do Estudante:</label>
                        <p class="form-control-plaintext bg-light p-2 rounded">
                            <code>#{{ str_pad($student->id, 6, '0', STR_PAD_LEFT) }}</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir o estudante <strong id="studentName"></strong>?</p>
                <p class="text-muted small">Esta ação não pode ser desfeita e removerá permanentemente todos os dados do estudante, incluindo sua foto.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Excluir Estudante
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let deleteStudentId = null;
    
    function confirmDelete(studentId, studentName) {
        deleteStudentId = studentId;
        document.getElementById('studentName').textContent = studentName;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteStudentId) {
            document.getElementById('delete-form-' + deleteStudentId).submit();
        }
    });
</script>
@endpush

@push('styles')
<style>
    .form-control-plaintext {
        border: 1px solid #e3e6f0;
        margin-bottom: 0;
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    
    .badge {
        font-size: 0.875rem;
    }
    
    .text-gray-700 {
        color: #5a5c69 !important;
    }
    
    .text-gray-800 {
        color: #3a3b45 !important;
    }
    
    code {
        background-color: #f8f9fc;
        color: #e74a3b;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
</style>
@endpush