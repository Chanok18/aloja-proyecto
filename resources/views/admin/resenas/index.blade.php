@extends('layouts.app-dashboard')

@section('title', 'Reseñas')
@section('role-name', 'Panel de Administrador')
@section('page-title', 'Gestión de Reseñas')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.hospedajes.index') }}">🏠 Hospedajes</a>
    <a href="{{ route('admin.reservas.index') }}">📅 Reservas</a>
    <a href="{{ route('admin.pagos.index') }}">💳 Pagos</a>
    <a href="{{ route('admin.resenas.index') }}" class="active">⭐ Reseñas</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de Reseñas</h2>
        <a href="{{ route('admin.resenas.create') }}" class="btn btn-primary">+ Nueva Reseña</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    <!-- Estadísticas -->
    <div class="stats-grid" style="margin-bottom: 30px;">
        <div class="stat-card">
            <h3>Total Reseñas</h3>
            <p>{{ $totalResenas }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Reseñas Positivas</h3>
            <p>{{ $resenasPositivas }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>Calificación Promedio</h3>
            <p>{{ number_format($promedioCalificacion ?? 0, 1) }} ⭐</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hospedaje</th>
                <th>Calificación</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resenas as $resena)
                <tr>
                    <td>{{ $resena->id_resena }}</td>
                    <td>{{ $resena->usuario->nombre }} {{ $resena->usuario->apellido }}</td>
                    <td>{{ $resena->hospedaje->titulo }}</td>
                    <td>
                        <span style="font-size: 18px; color: #f59e0b;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $resena->calificacion)
                                    ⭐
                                @else
                                    ☆
                                @endif
                            @endfor
                        </span>
                        <br>
                        <small style="color: #666;">{{ $resena->calificacion }}/5</small>
                    </td>
                    <td style="max-width: 300px;">
                        {{ Str::limit($resena->comentario ?? 'Sin comentario', 50) }}
                    </td>
                    <td>{{ $resena->fecha_resena->format('d/m/Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.resenas.show', $resena->id_resena) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                👁️ Ver
                            </a>
                            <a href="{{ route('admin.resenas.edit', $resena->id_resena) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.resenas.destroy', $resena->id_resena) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?');"
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
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        No hay reseñas registradas aún.
                        <br><br>
                        <a href="{{ route('admin.resenas.create') }}" class="btn btn-primary">+ Crear primera reseña</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    @if($resenas->hasPages())
        <div style="margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #666;">
                    Mostrando {{ $resenas->firstItem() }} a {{ $resenas->lastItem() }} de {{ $resenas->total() }} reseñas
                </p>
                <div style="display: flex; gap: 5px;">
                    @if ($resenas->onFirstPage())
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Anterior</span>
                    @else
                        <a href="{{ $resenas->previousPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Anterior</a>
                    @endif

                    @if ($resenas->hasMorePages())
                        <a href="{{ $resenas->nextPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Siguiente</a>
                    @else
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection