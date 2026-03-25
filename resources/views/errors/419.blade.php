<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 415 - Tipo de contenido no soportado</title>
    <link rel="icon" href="{{ asset('storage/logos/logosysredondo.webp') }}" type="image/webp">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .error-wrapper {
            max-width: 600px;
            width: 100%;
            background-color: white;
            padding: 3rem 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .error-code {
            font-size: 4rem;
            font-weight: 700;
            color: #333333;
            margin-bottom: 1rem;
            line-height: 1;
        }

        .error-icon {
            font-size: 3rem;
            color: #999999;
            margin-bottom: 1.5rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333333;
            margin-bottom: 0.75rem;
        }

        .error-message {
            font-size: 0.95rem;
            color: #666666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-details {
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-left: 3px solid #cccccc;
            margin-bottom: 2rem;
            text-align: left;
            border-radius: 4px;
        }

        .error-details p {
            font-size: 0.85rem;
            color: #666666;
            margin: 0.5rem 0;
            line-height: 1.5;
        }

        .error-details strong {
            color: #333333;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
        }

        .btn-primary {
            background-color: #333333;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1a1a1a;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: #333333;
            border: 1px solid #d0d0d0;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
            color: #1a1a1a;
            transform: translateY(-1px);
        }

        .footer-note {
            font-size: 0.8rem;
            color: #999999;
            border-top: 1px solid #e0e0e0;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 640px) {
            .error-wrapper {
                padding: 2rem 1.5rem;
            }

            .error-code {
                font-size: 3rem;
            }

            .error-icon {
                font-size: 2.5rem;
            }

            .error-title {
                font-size: 1.25rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-wrapper">
        <div class="error-icon">⚠️</div>

        <div class="error-code">415</div>

        <h1 class="error-title">Tipo de contenido no soportado</h1>

        <p class="error-message">
            El formato del archivo que intentaste enviar no es válido o no está soportado por este servidor.
        </p>

        <div class="error-details">
            <p><strong>¿Qué significa esto?</strong></p>
            <p>El servidor rechazó tu solicitud porque el tipo de contenido (formato del archivo) no es compatible. Esto ocurre cuando:</p>
            <p style="margin-top: 1rem;">
                • Intentas cargar un tipo de archivo no permitido<br>
                • El formulario envía datos en un formato incorrecto<br>
                • Falta o es incorrecta la cabecera Content-Type
            </p>
        </div>

        <div class="button-group">
            <button type="button" class="btn btn-primary" onclick="window.history.back()">
                ← Volver atrás
            </button>
            <a href="{{ route('home') ?? '/' }}" class="btn btn-secondary">
                Ir al inicio
            </a>
        </div>

        <div class="footer-note">
            Si el problema persiste, contacta al administrador del sistema.
        </div>
    </div>
</body>
</html>
