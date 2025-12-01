@extends('layouts.app-dashboard')

@section('content')
<div style="padding: 30px;">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1A1A1A; margin-bottom: 8px;">
            Gestionar Estado de Reserva
        </h1>
        <p style="color: #6B7280;">Cambia el estado de la reserva según su progreso</p>
    </div>

    <!-- Info de la Reserva -->
    <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1A1A1A;">
            📋 Información de la Reserva
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Código de Reserva</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">#{{ str_pad($reserva->id_reserva, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Viajero</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Hospedaje</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">{{ $reserva->hospedaje->titulo }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Fechas</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">
                    {{ $reserva->fecha_inicio->format('d/m/Y') }} - {{ $reserva->fecha_fin->format('d/m/Y') }}
                </p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Total</p>
                <p style="font-size: 16px; font-weight: 600; color: #1A1A1A;">S/. {{ number_format($reserva->total, 2) }}</p>
            </div>
            
            <div>
                <p style="font-size: 13px; color: #6B7280; margin-bottom: 4px;">Estado Actual</p>
                <p style="font-size: 16px; font-weight: 600; 
                    @if($reserva->estado === 'confirmada') color: #10B981;
                    @elseif($reserva->estado === 'pendiente') color: #F59E0B;
                    @elseif($reserva->estado === 'completada') color: #3B82F6;
                    @else color: #EF4444;
                    @endif
                ">
                    {{ ucfirst($reserva->estado) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Formulario para cambiar estado -->
    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #1A1A1A;">
            🔄 Cambiar Estado
        </h3>

        <form action="{{ route('admin.reservas.update', $reserva->id_reserva) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 600; color: #1A1A1A; margin-bottom: 8px;">
                    Nuevo Estado *
                </label>
                <select name="estado" required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 15px;">
                    <option value="pendiente" {{ $reserva->estado === 'pendiente' ? 'selected' : '' }}>
                        ⏳ Pendiente
                    </option>
                    <option value="confirmada" {{ $reserva->estado === 'confirmada' ? 'selected' : '' }}>
                        ✅ Confirmada
                    </option>
                    <option value="completada" {{ $reserva->estado === 'completada' ? 'selected' : '' }}>
                        🎉 Completada
                    </option>
                    <option value="cancelada" {{ $reserva->estado === 'cancelada' ? 'selected' : '' }}>
                        ❌ Cancelada
                    </option>
                </select>
                @error('estado')
                    <p style="color: #EF4444; font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <p style="font-size: 14px; color: #78350F; line-height: 1.6;">
                    <strong>ℹ️ Nota:</strong><br>
                    • <strong>Pendiente:</strong> Esperando confirmación del anfitrión<br>
                    • <strong>Confirmada:</strong> Reserva aceptada y activa<br>
                    • <strong>Completada:</strong> El viajero ya se hospedó<br>
                    • <strong>Cancelada:</strong> Reserva cancelada por el usuario o admin
                </p>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" 
                        style="flex: 1; padding: 14px 24px; background: #2B4F9B; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    💾 Actualizar Estado
                </button>
                <a href="{{ route('admin.reservas.index') }}" 
                   style="flex: 1; padding: 14px 24px; background: #F3F4F6; color: #1A1A1A; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; display: block; transition: all 0.2s;">
                    ← Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection