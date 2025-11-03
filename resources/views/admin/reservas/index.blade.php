@extends('layouts.app-dashboard')

@section('title', 'Reservas')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Reservas')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}" class="active">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de Reservas</h2>
        <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary">+ Nueva Reserva</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hospedaje</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id_reserva }}</td>
                    <td>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</td>
                    <td>{{ $reserva->hospedaje->titulo }}</td>
                    <td>{{ $reserva->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $reserva->fecha_fin->format('d/m/Y') }}</td>
                    <td>S/. {{ number_format($reserva->total, 2) }}</td>
                    <td>
                        @if($reserva->estado === 'pendiente')
                            <span class="badge badge-warning">Pendiente</span>
                        @elseif($reserva->estado === 'confirmada')
                            <span class="badge badge-success">Confirmada</span>
                        @elseif($reserva->estado === 'completada')
                            <span class="badge badge-success">Completada</span>
                        @else
                            <span class="badge badge-danger">Cancelada</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.reservas.show', $reserva->id_reserva) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                👁️ Ver
                            </a>
                            <a href="{{ route('admin.reservas.edit', $reserva->id_reserva) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.reservas.destroy', $reserva->id_reserva) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta reserva?');"
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
                        No hay reservas registradas aún.
                        <br><br>
                        <a href="{{ route('admin.reservas.create') }}" class="btn btn-primary">+ Crear primera reserva</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    @if($reservas->hasPages())
        <div style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #666;">
                    Mostrando {{ $reservas->firstItem() }} a {{ $reservas->lastItem() }} de {{ $reservas->total() }} reservas
                </p>
                <div style="display: flex; gap: 5px;">
                    @if ($reservas->onFirstPage())
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Anterior</span>
                    @else
                        <a href="{{ $reservas->previousPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Anterior</a>
                    @endif

                    @if ($reservas->hasMorePages())
                        <a href="{{ $reservas->nextPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Siguiente</a>
                    @else
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection