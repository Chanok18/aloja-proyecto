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
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="stats-grid" style="margin-bottom: 30px;">
        <div class="stat-card">
            <h3>Total Hospedajes</h3>
            <p>{{ $total }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Disponibles</h3>
            <p>{{ $disponibles }}</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <h3>No Disponibles</h3>
            <p>{{ $nodisponibles }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Información</th>
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
                    <td>
                        @php
                            $fotoPrincipal = $hospedaje->fotos_galeria->where('es_principal', true)->first();
                        @endphp
                        <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            @if($fotoPrincipal)
                                <img src="{{ asset('storage/' . $fotoPrincipal->ruta_foto) }}" 
                                     alt="{{ $hospedaje->titulo }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px;">
                                    🏠
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong style="color: #1e3a8a;">{{ $hospedaje->titulo }}</strong>
                        <br>
                        <small style="color: #666;">ID: {{ $hospedaje->id_hospedaje }}</small>
                        <br>
                        @if($hospedaje->fotos_galeria->count() > 0)
                            <small style="color: #10b981;">
                                📸 {{ $hospedaje->fotos_galeria->count() }} {{ $hospedaje->fotos_galeria->count() == 1 ? 'foto' : 'fotos' }}
                            </small>
                        @else
                            <small style="color: #ef4444;">Sin fotos</small>
                        @endif
                    </td>
                    <td>{{ $hospedaje->ubicacion }}</td>
                    <td>
                        {{ $hospedaje->anfitrion->nombre }} {{ $hospedaje->anfitrion->apellido }}
                        <br>
                        <small style="color: #666;">{{ $hospedaje->anfitrion->correo }}</small>
                    </td>
                    <td><strong>S/. {{ number_format($hospedaje->precio, 2) }}</strong></td>
                    <td>{{ $hospedaje->capacidad }} personas</td>
                    <td>
                        @if($hospedaje->disponible)
                            <span class="badge badge-success">✅ Disponible</span>
                        @else
                            <span class="badge badge-danger">❌ No disponible</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px; flex-direction: column;">
                            <a href="{{ route('admin.hospedajes.show', $hospedaje->id_hospedaje) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px; text-align: center;">
                                👁️ Ver
                            </a>
                            <a href="{{ route('admin.hospedajes.edit', $hospedaje->id_hospedaje) }}" 
                               class="btn btn-primary" style="font-size: 12px; padding: 6px 12px; background: #f59e0b; text-align: center;">
                                ✏️ Editar
                            </a>
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