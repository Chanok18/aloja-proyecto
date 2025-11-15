@extends('layouts.app-dashboard')

@section('title', 'Pagos')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Pagos')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}" class="active">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de Pagos</h2>
        <a href="{{ route('admin.pagos.create') }}" class="btn btn-primary">+ Registrar Pago</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="stats-grid" style="margin-bottom: 30px;">
        <div class="stat-card">
            <h3>Total Recaudado</h3>
            <p>S/. {{ number_format($totalRecaudado, 2) }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Pagos Completados</h3>
            <p>{{ $pagosCompletados }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Pagos Pendientes</h3>
            <p>{{ $pagosPendientes }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Reserva</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos as $pago)
                <tr>
                    <td>{{ $pago->id_pago }}</td>
                    <td>
                        Reserva #{{ $pago->id_reserva }}<br>
                        <small style="color: #666;">{{ $pago->reserva->hospedaje->titulo }}</small>
                    </td>
                    <td>{{ $pago->reserva->usuario->nombre }} {{ $pago->reserva->usuario->apellido }}</td>
                    <td>S/. {{ number_format($pago->monto, 2) }}</td>
                    <td>{{ ucfirst($pago->metodo) }}</td>
                    <td>
                        @if($pago->estado_pago === 'completado')
                            <span class="badge badge-success">Completado</span>
                        @elseif($pago->estado_pago === 'pendiente')
                            <span class="badge badge-warning">Pendiente</span>
                        @elseif($pago->estado_pago === 'fallido')
                            <span class="badge badge-danger">Fallido</span>
                        @else
                            <span class="badge badge-warning">Reembolsado</span>
                        @endif
                    </td>
                    <td>{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.pagos.show', $pago->id_pago) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                👁️ Ver
                            </a>
                            <a href="{{ route('admin.pagos.edit', $pago->id_pago) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.pagos.destroy', $pago->id_pago) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este pago?');"
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px;">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                        No hay pagos registrados aún.
                        <br><br>
                        <a href="{{ route('admin.pagos.create') }}" class="btn btn-primary">+ Registrar primer pago</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    @if($pagos->hasPages())
        <div style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #666;">
                    Mostrando {{ $pagos->firstItem() }} a {{ $pagos->lastItem() }} de {{ $pagos->total() }} pagos
                </p>
                <div style="display: flex; gap: 5px;">
                    @if ($pagos->onFirstPage())
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Anterior</span>
                    @else
                        <a href="{{ $pagos->previousPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Anterior</a>
                    @endif

                    @if ($pagos->hasMorePages())
                        <a href="{{ $pagos->nextPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Siguiente</a>
                    @else
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
