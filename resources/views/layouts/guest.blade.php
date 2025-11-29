<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Aloja.pe') }}</title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, rgba(43, 79, 155, 0.9) 0%, rgba(43, 79, 155, 0.7) 100%), 
                        url('https://images.unsplash.com/photo-1531065208531-4036c0dba3f5?w=1920') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-container {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            animation: slideUp 0.4s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .auth-logo h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2B4F9B;
            margin-bottom: 8px;
        }
        
        .auth-logo .pe {
            color: #F5C344;
        }
        
        .auth-logo p {
            font-size: 14px;
            color: #6B7280;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1A1A1A;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            background: #F9FAFB;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #2B4F9B;
            background: white;
            box-shadow: 0 0 0 3px rgba(43, 79, 155, 0.1);
        }
        
        .form-input::placeholder {
            color: #9CA3AF;
        }
        
        .form-error {
            color: #DC2626;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 16px 0;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #2B4F9B;
        }
        
        .checkbox-group label {
            font-size: 14px;
            color: #4B5563;
            cursor: pointer;
        }
        
        .btn-primary {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: #2B4F9B;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        
        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(43, 79, 155, 0.3);
        }
        
        .btn-secondary {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            color: #1A1A1A;
            background: #F5C344;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        
        .btn-secondary:hover {
            background: #E5B334;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 195, 68, 0.3);
        }
        
        .link-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6B7280;
        }
        
        .link-text a {
            color: #2B4F9B;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .link-text a:hover {
            color: #1e3a8a;
            text-decoration: underline;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 12px;
        }
        
        .forgot-password a {
            font-size: 14px;
            color: #2B4F9B;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #E5E7EB;
        }
        
        .divider span {
            background: white;
            padding: 0 16px;
            position: relative;
            color: #6B7280;
            font-size: 14px;
        }
        
        .alert-success {
            background: #D1FAE5;
            border: 1px solid #10B981;
            color: #065F46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon span {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }
        
        .input-icon .form-input {
            padding-left: 48px;
        }
        
        @media (max-width: 480px) {
            .auth-container {
                padding: 32px 24px;
            }
            
            .auth-logo h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{ $slot }}
    </div>
</body>
</html>