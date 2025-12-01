@extends('layouts.app-dashboard')

@section('content')
<div style="padding: 30px;">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1A1A1A; margin-bottom: 8px;">
            Validar Pago
        </h1>
        <p style="color: #6B7280;">Valida, cancela o reembolsa el pago si es necesario</p>
    </div>

    <!-- Info del Pago -->
    <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1A1A1A;">
            💳 Información del Pago
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Código de Pago</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">#{{ str_pad($pago->id_pago, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Referencia</p>
                <p style="font-size: 14px; font-weight: 600; color: #1A1A1A; font-family: monospace;">{{ $pago->referencia_pago }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Usuario</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $pago->reserva->usuario->nombre }} {{ $pago->reserva->usuario->apellido }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Hospedaje</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $pago->reserva->hospedaje->titulo }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Monto Pagado</p>
                <p style="font-size: 20px; font-weight: 700; color: #10B981;">S/. {{ number_format($pago->monto, 2) }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Método de Pago</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ ucfirst($pago->metodo) }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Fecha del Pago</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $pago->fecha_pago->format('d/m/Y H:i:s') }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Estado Actual</p>
                <p style="font-size: 16px; font-weight: 600; 
                    @if($pago->estado_pago === 'completado') color: #10B981;
                    @elseif($pago->estado_pago === 'pendiente') color: #F59E0B;
                    @elseif($pago->estado_pago === 'reembolsado') color: #3B82F6;
                    @else color: #EF4444;
                    @endif
                ">
                    {{ ucfirst($pago->estado_pago) }}
                </p>
            </div>
        </div>

        <!-- Detalle de la Reserva -->
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #E5E7EB;">
            <p style="font-size: 13px; color: #6B7280; margin-bottom: 12px;">📋 Detalle de la Reserva</p>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <div>
                    <p style="font-size: 13px; color: #6B7280;">Check-in</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1A1A1A;">{{ $pago->reserva->fecha_inicio->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p style="font-size: 13px; color: #6B7280;">Check-out</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1A1A1A;">{{ $pago->reserva->fecha_fin->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p style="font-size: 13px; color: #6B7280;">Estado Reserva</p>
                    <p style="font-size: 14px; font-weight: 600; color: #1A1A1A;">{{ ucfirst($pago->reserva->estado) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Validación -->
    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1A1A1A;">
            🔄 Gestionar Estado del Pago
        </h3>

        <form action="{{ route('admin.pagos.update', $pago->id_pago) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; color: #1A1A1A; margin-bottom: 8px;">
                    Nuevo Estado *
                </label>
                <select name="estado_pago" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 15px;">
                    <option value="completado" {{ $pago->estado_pago === 'completado' ? 'selected' : '' }}>
                        ✅ Completado (Pago Validado)
                    </option>
                    <option value="pendiente" {{ $pago->estado_pago === 'pendiente' ? 'selected' : '' }}>
                        ⏳ Pendiente (En Revisión)
                    </option>
                    <option value="fallido" {{ $pago->estado_pago === 'fallido' ? 'selected' : '' }}>
                        ❌ Fallido (Rechazado/Fraude)
                    </option>
                    <option value="reembolsado" {{ $pago->estado_pago === 'reembolsado' ? 'selected' : '' }}>
                        💰 Reembolsado (Devuelto al Usuario)
                    </option>
                </select>
                @error('estado_pago')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <p style="font-size: 14px; color: #78350F; line-height: 1.6;">
                    <strong>ℹ️ Guía de Estados:</strong><br>
                    • <strong>Completado:</strong> El pago es válido y procesado correctamente<br>
                    • <strong>Pendiente:</strong> En revisión (posible fraude o verificación necesaria)<br>
                    • <strong>Fallido:</strong> Pago rechazado o detectado como fraudulento<br>
                    • <strong>Reembolsado:</strong> Dinero devuelto al usuario (cancelación, error, etc.)
                </p>
            </div>

            <div style="background: #FEE2E2; border-left: 4px solid #EF4444; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <p style="font-size: 14px; color: #991B1B; line-height: 1.6;">
                    <strong>⚠️ ADVERTENCIA:</strong> Los pagos NO se pueden eliminar (son registros financieros legales). Solo puedes cambiar su estado para gestión interna.
                </p>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" 
                        style="flex: 1; padding: 14px 24px; background: #2B4F9B; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    💾 Actualizar Estado
                </button>
                <a href="{{ route('admin.pagos.index') }}" 
                   style="flex: 1; padding: 14px 24px; background: #F3F4F6; color: #1A1A1A; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: block; transition: all 0.2s;">
                    ← Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection