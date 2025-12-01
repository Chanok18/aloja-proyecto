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

    <!-- FILTROS -->
    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">🔍 Filtros de Búsqueda</h3>
        
        <form method="GET" action="{{ route('admin.pagos.index') }}">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                
                <!-- Filtro: Estado -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600;">Estado:</label>
                    <select name="estado_pago" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px;">
                        <option value="">Todos los estados</option>
                        <option value="completado" {{ request('estado_pago') == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="fallido" {{ request('estado_pago') == 'fallido' ? 'selected' : '' }}>Fallido</option>
                        <option value="reembolsado" {{ request('estado_pago') == 'reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                </div>

                <!-- Filtro: Método -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600;">Método:</label>
                    <select name="metodo" style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px;">
                        <option value="">Todos los métodos</option>
                        <option value="yape" {{ request('metodo') == 'yape' ? 'selected' : '' }}>Yape</option>
                        <option value="plin" {{ request('metodo') == 'plin' ? 'selected' : '' }}>Plin</option>
                        <option value="tarjeta" {{ request('metodo') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="paypal" {{ request('metodo') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="transferencia" {{ request('metodo') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    </select>
                </div>

                <!-- Filtro: Fecha Desde -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600;">Desde:</label>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px;">
                </div>

                <!-- Filtro: Fecha Hasta -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600;">Hasta:</label>
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                           style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px;">
                </div>

                <!-- Filtro: Monto Mínimo -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600;">Monto Mín:</label>
                    <input type="number" name="monto_min" value="{{ request('monto_min') }}" 
                           placeholder="S/. 0" step="0.01" min="0"
                           style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px;">
                </div>

                <!-- Filtro: Monto Máximo -->
                <div>
                    <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 600;">Monto Máx:</label>
                    <input type="number" name="monto_max" value="{{ request('monto_max') }}" 
                           placeholder="S/. 9999" step="0.01" min="0"
                           style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 5px;">
                </div>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button type="submit" class="btn btn-primary">
                    🔍 Buscar
                </button>
                <a href="{{ route('admin.pagos.index') }}" class="btn" style="background: #6b7280; color: white;">
                    🔄 Limpiar Filtros
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de Pagos -->
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
                    <td><strong>S/. {{ number_format($pago->monto, 2) }}</strong></td>
                    <td>
                        @if($pago->metodo == 'yape')
                            <span style="color: #722F87;">💜 Yape</span>
                        @elseif($pago->metodo == 'plin')
                            <span style="color: #00A19B;">💚 Plin</span>
                        @elseif($pago->metodo == 'tarjeta')
                            <span style="color: #1e3a8a;">💳 Tarjeta</span>
                        @elseif($pago->metodo == 'paypal')
                            <span style="color: #0070ba;">🅿️ PayPal</span>
                        @else
                            <span style="color: #666;">🏦 {{ ucfirst($pago->metodo) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($pago->estado_pago === 'completado')
                            <span class="badge badge-success">✅ Completado</span>
                        @elseif($pago->estado_pago === 'pendiente')
                            <span class="badge badge-warning">⏳ Pendiente</span>
                        @elseif($pago->estado_pago === 'fallido')
                            <span class="badge badge-danger">❌ Fallido</span>
                        @else
                            <span class="badge badge-warning">🔄 Reembolsado</span>
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
                               class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px;">
                                ✏️ Editar                 
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                        @if(request()->hasAny(['estado_pago', 'metodo', 'fecha_desde', 'fecha_hasta', 'monto_min', 'monto_max']))
                            🔍 No se encontraron pagos con los filtros aplicados.
                            <br><br>
                            <a href="{{ route('admin.pagos.index') }}" class="btn btn-primary">🔄 Ver Todos los Pagos</a>
                        @else
                            No hay pagos registrados aún.
                            <br><br>
                            <a href="{{ route('admin.pagos.create') }}" class="btn btn-primary">+ Registrar primer pago</a>
                        @endif
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
                        <a href="{{ $pagos->appends(request()->query())->previousPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Anterior</a>
                    @endif

                    @if ($pagos->hasMorePages())
                        <a href="{{ $pagos->appends(request()->query())->nextPageUrl() }}" style="padding: 8px 12px; background: #1e3a8a; color: white; border-radius: 5px; text-decoration: none;">Siguiente</a>
                    @else
                        <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 5px;">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection