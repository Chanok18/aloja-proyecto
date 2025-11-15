@extends('layouts.app-dashboard')

@section('title', 'Hospedajes')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Hospedajes')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}" class="active">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}">⭐ Reseñas</a>
    
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de Hospedajes</h2>
        <a href="{{ route('admin.hospedajes.create') }}" class="btn btn-primary">+ Nuevo Hospedaje</a>
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
                <th>Título</th>
                <th>Ubicación</th>
                <th>Anfitrión</th>
                <th>Precio</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hospedajes as $hospedaje)
                <tr>
                    <td>{{ $hospedaje->id_hospedaje }}</td>
                    <td>{{ $hospedaje->titulo }}</td>
                    <td>{{ $hospedaje->ubicacion }}</td>
                    <td>{{ $hospedaje->anfitrion->nombre }} {{ $hospedaje->anfitrion->apellido }}</td>
                    <td>S/. {{ number_format($hospedaje->precio, 2) }}</td>
                    <td>{{ $hospedaje->capacidad }} personas</td>
                    <td>
                        @if($hospedaje->disponible)
                            <span class="badge badge-success">Disponible</span>
                        @else
                            <span class="badge badge-danger">No disponible</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.hospedajes.show', $hospedaje->id_hospedaje) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                👁️ Ver
                            </a>
                            <a href="{{ route('admin.hospedajes.edit', $hospedaje->id_hospedaje) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.hospedajes.destroy', $hospedaje->id_hospedaje) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este hospedaje?');"
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
                        No hay hospedajes registrados aún.
                        <br><br>
                        <a href="{{ route('admin.hospedajes.create') }}" class="btn btn-primary">+ Crear primer hospedaje</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    @if($hospedajes->hasPages())
        <div style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #666;">
                    Mostrando {{ $hospedajes->firstItem() }} a {{ $hospedajes->lastItem() }} de {{ $hospedajes->total() }} hospedajes
                </p>
                <div style="display: flex; gap: 5px;">
                    @if ($hospedajes->onFirstPage())
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Anterior</span>
                    @else
                        <a href="{{ $hospedajes->previousPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Anterior</a>
                    @endif

                    @if ($hospedajes->hasMorePages())
                        <a href="{{ $hospedajes->nextPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Siguiente</a>
                    @else
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection