@extends('layouts.app')

@section('title', 'Todos os Estudantes - Sistema de Matrícula de Estudantes')
@section('page-title', 'Todos os Estudantes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Estudantes</h6>
                <a href="{{ route('students.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Adicionar Novo Estudante
                </a>
            </div>
            <div class="card-body">
                @if($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Matrícula</th>
                                    <th>Turma</th>
                                    <th>Cidade</th>
                                    <th>Contato</th>
                                    <th>Data de Cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                <tr>
                                    <td>{{ $students->firstItem() + $index }}</td>
                                    <td>
                                        @if($student->photo)
                                            <img src="{{ asset('storage/students/' . $student->photo) }}" 
                                                 alt="{{ $student->name }}" 
                                                 class="rounded-circle" 
                                                 width="50" height="50"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">{{ $student->name }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $student->roll }}</span>
                                    </td>
                                    <td>{{ $student->class }}</td>
                                    <td>{{ $student->city }}</td>
                                    <td>{{ $student->pcontact }}</td>
                                    <td>{{ $student->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('students.show', $student) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="Ver Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('students.edit', $student) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Editar Estudante">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    title="Excluir Estudante"
                                                    onclick="confirmDelete({{ $student->id }}, '{{ $student->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Hidden delete form -->
                                        <form id="delete-form-{{ $student->id }}" 
                                              action="{{ route('students.destroy', $student) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <p class="text-muted mb-0">
                                Mostrando {{ $students->firstItem() }} a {{ $students->lastItem() }} de {{ $students->total() }} resultados
                            </p>
                        </div>
                        <div>
                            {{ $students->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-5x text-gray-300 mb-4"></i>
                        <h4 class="text-muted mb-3">Nenhum Estudante Encontrado</h4>
                        <p class="text-muted mb-4">Comece adicionando seu primeiro estudante ao sistema.</p>
                        <a href="{{ route('students.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Adicionar Primeiro Estudante
                        </a>
                    </div>
                @endif
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
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.025);
    }
</style>
@endpush