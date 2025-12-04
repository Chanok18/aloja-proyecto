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
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Lista de Reseñas</h2>
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

    <!-- Filtros -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 25px;">
        <h3 style="margin-bottom: 20px; color: #1A1A1A; font-size: 18px; font-weight: 600;">
            🔍 Filtros de Búsqueda
        </h3>
        
        <form action="{{ route('admin.resenas.index') }}" method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                
                <!-- Filtro: Calificación -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Calificación:</label>
                    <select name="calificacion" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
                        <option value="">Todas las calificaciones</option>
                        <option value="5" {{ request('calificacion') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 estrellas)</option>
                        <option value="4" {{ request('calificacion') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 estrellas)</option>
                        <option value="3" {{ request('calificacion') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 estrellas)</option>
                        <option value="2" {{ request('calificacion') == '2' ? 'selected' : '' }}>⭐⭐ (2 estrellas)</option>
                        <option value="1" {{ request('calificacion') == '1' ? 'selected' : '' }}>⭐ (1 estrella)</option>
                    </select>
                </div>

                <!-- Filtro: Usuario -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Usuario:</label>
                    <select name="usuario_id" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
                        <option value="">Todos los usuarios</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}" {{ request('usuario_id') == $usuario->id_usuario ? 'selected' : '' }}>
                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro: Hospedaje -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Hospedaje:</label>
                    <select name="hospedaje_id" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
                        <option value="">Todos los hospedajes</option>
                        @foreach($hospedajes as $hospedaje)
                            <option value="{{ $hospedaje->id_hospedaje }}" {{ request('hospedaje_id') == $hospedaje->id_hospedaje ? 'selected' : '' }}>
                                {{ Str::limit($hospedaje->titulo, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro: Fecha Desde -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Desde:</label>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
                </div>

                <!-- Filtro: Fecha Hasta -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Hasta:</label>
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 12px 24px; background: #2B4F9B; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    🔍 Buscar
                </button>
                <a href="{{ route('admin.resenas.index') }}" style="padding: 12px 24px; background: #6B7280; color: white; border: none; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.2s;">
                    🔄 Limpiar Filtros
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Hospedaje</th>
                <th style="width: 150px;">Calificación</th>
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
                    <td>{{ Str::limit($resena->hospedaje->titulo, 30) }}</td>
                    <td style="text-align: center;">
                        <div style="font-size: 28px; line-height: 1; margin-bottom: 8px;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $resena->calificacion)
                                    <span style="color: #F5C344;">⭐</span>
                                @else
                                    <span style="color: #D1D5DB;">☆</span>
                                @endif
                            @endfor
                        </div>
                        <span style="font-size: 14px; font-weight: 600; color: #1A1A1A;">{{ $resena->calificacion }}/5</span>
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
                            <form action="{{ route('admin.resenas.destroy', $resena->id_resena) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta reseña? Esta acción no se puede deshacer.');"
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
                        @if(request()->hasAny(['calificacion', 'usuario_id', 'hospedaje_id', 'fecha_desde', 'fecha_hasta']))
                            No se encontraron reseñas con los filtros aplicados.
                            <br><br>
                            <a href="{{ route('admin.resenas.index') }}" class="btn btn-primary">🔄 Limpiar Filtros</a>
                        @else
                            No hay reseñas registradas aún.
                        @endif
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
                        <a href="{{ $resenas->appends(request()->query())->previousPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Anterior</a>
                    @endif

                    @if ($resenas->hasMorePages())
                        <a href="{{ $resenas->appends(request()->query())->nextPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Siguiente</a>
                    @else
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection