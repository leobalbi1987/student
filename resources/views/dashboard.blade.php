@extends('layouts.app')

@section('title', 'Painel - Sistema de Matrícula de Estudantes')
@section('page-title', 'Painel')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total de Estudantes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total de Usuários
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Usuários Ativos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Status do Sistema
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span class="badge bg-success">Online</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-server fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Students -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Estudantes Recentes</h6>
                <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i> Ver Todos
                </a>
            </div>
            <div class="card-body">
                @if($recentStudents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Matrícula</th>
                                    <th>Turma</th>
                                    <th>Cidade</th>
                                    <th>Contato</th>
                                    <th>Adicionado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStudents as $student)
                                <tr>
                                    <td>
                                        @if($student->photo)
                                            <img src="{{ asset('storage/students/' . $student->photo) }}" 
                                                 alt="{{ $student->name }}" 
                                                 class="rounded-circle" 
                                                 width="40" height="40">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->roll }}</td>
                                    <td>{{ $student->class }}</td>
                                    <td>{{ $student->city }}</td>
                                    <td>{{ $student->pcontact }}</td>
                                    <td>{{ $student->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Nenhum estudante encontrado. <a href="{{ route('students.create') }}">Adicione o primeiro estudante</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ações Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Adicionar Novo Estudante
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>
                        Ver Todos os Estudantes
                    </a>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informações do Sistema</h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Versão do Laravel:</span>
                        <span class="text-muted">{{ app()->version() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Versão do PHP:</span>
                        <span class="text-muted">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Usuário Atual:</span>
                        <span class="text-muted">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Último Login:</span>
                        <span class="text-muted">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
</style>
@endpush