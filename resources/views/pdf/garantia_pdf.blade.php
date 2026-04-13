<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            padding: 4px;
            background: #ffffff;
            color: #1f2937;
            line-height: 1.25;
            font-size: 9px;
            height: 100vh;
            overflow: hidden;
        }

        /* Strict A4 page constraints */
        @page {
            size: A4;
            margin: 0.3cm;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 2px;
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            page-break-inside: avoid;
            height: 100mm;
        }

        table tbody {
            height: 100%;
        }

        table tr {
            height: auto;
        }
        
        .header-row {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%); /* Changed from blue to dark gray gradient */
            color: white;
        }
        
        .title-row {
            background: #e5e7eb; /* Changed from blue-tinted to neutral gray */
            border-bottom: 2px solid #6b7280; /* Changed from blue to gray border */
        }
        
        .section-header {
            background: #d1d5db !important; /* Changed from blue-tinted to neutral gray */
            color: #111827 !important; /* Darker text for better contrast */
            font-weight: 700 !important;
            border-left: 4px solid #4b5563 !important; /* Changed from blue to dark gray border */
            position: relative;
        }
        
        .section-header::before {
            color: #4b5563; /* Changed from blue to dark gray icon */
            margin-right: 6px;
            font-size: 8px;
        }
        
        th, td {
            font-size: 9px;
            border: 1px solid #9ca3af;
            padding: 2px 4px;
            background-color: #ffffff;
            width: calc(100% / 6);
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
        }
        
        th {
            background: #e5e7eb; /* Changed to neutral gray */
            font-weight: 700;
            text-align: center;
            color: #111827; /* Darker text color */
        }
        
        .name-data {
            font-weight: 700;
            font-size: 9px !important;
            color: #111827;
            background: #e5e7eb !important;
        }

        .data-value {
            background: #ffffff !important;
            color: #111827;
            font-weight: 500;
            font-size: 9px;
        }
        
        .text-end {
            text-align: right;
            font-weight: 600;
            color: #374151;
        }
        
        .img-cab {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        
        .cel-img {
            padding: 3px !important; /* Reduced padding from 4px to 3px */
            background: #ffffff !important;
        }
        
        /* Fixed footer positioning and signature overlap */
        .footer-wrapper {
            width: 100%;
            margin-top: 3px;
            padding: 40px 0;
        }

        .footerDiv {
            width: 100%;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 0;
            min-height: 40px;
        }

        .firma-empresa {
            width: 120px;
            height: 35px;
            object-fit: contain;
            margin-right: 10px;
            display: block;
        }

        .firma-cliente {
            border-top: 2px solid #111827;
            width: 120px;
            text-align: center;
            padding-top: 4px;
            font-weight: 700;
            color: #111827;
            font-size: 8px;
            flex-shrink: 0;
            margin-bottom: 0;
        }
        
        .form-separator {
            text-align: center;
            margin: 3px 0;
            position: relative;
            border-top: 1px dashed #9ca3af;
        }
        
        .form-separator::before {
            content: "*/*";
            background: white;
            padding: 0 8px; /* Reduced padding from 10px to 8px */
            color: #6b7280;
            font-size: 11px; /* Smaller scissors from 12px to 11px */
            position: absolute;
            top: -5px; /* Adjusted position from -6px to -5px */
            left: 50%;
            transform: translateX(-50%);
        }
        
        .codigo-value {
            font-family: 'Courier New', monospace;
            background: #e5e7eb !important;
            font-weight: 700;
            color: #111827;
            letter-spacing: 0.3px;
            font-size: 10px;
        }
        
        .compact-row td {
            padding: 2px 4px !important;
        }

        /* Constrained text areas to prevent overflow */
        .recepcion-cell {
            max-height: 28px;
            overflow: hidden;
            padding: 4px !important;
        }

        .falla-cell {
            max-height: 22px;
            overflow: hidden;
            padding: 4px !important;
        }

        /* Clause message styling */
        .clause-message {
            font-size: 6.5px;
            color: #6b7280;
            font-style: italic;
            text-align: justify;
            padding: 2px 5px;
            margin-top: 2px;
            border-left: 2px solid #9ca3af;
            background: #f9fafb;
            line-height: 1.25;
            height: 18px;
            overflow: hidden;
        }

        .clause-message strong {
            color: #374151;
            font-style: normal;
        }
        
        /* Enhanced print optimization for A4 */
        @media print {
            body {
                padding: 3px;
                font-size: 9px;
            }

            .form-separator {
                page-break-inside: avoid;
                margin: 15px 0;
            }

            table {
                page-break-inside: avoid;
                box-shadow: none;
                margin-bottom: 3px;
            }

            .footerDiv {
                margin-top: 6px;
                height: 40px;
            }

            .recepcion-cell, .falla-cell {
                overflow: hidden;
                max-height: 28px;
            }
        }
    </style>
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
    </svg>
    <!-- First warranty form with improved structure -->
    <table>
        <thead>
            <tr class="header-row">
                <th class="cel-img" colspan="6">
                    <img class="img-cab" src="{{$cabecera}}" alt="Logo de la empresa">
                </th>
            </tr>
            <tr class="title-row">
                <th colspan="6" style="font-size: 12px; font-weight: 700; color: #111827;">
                    <u>{{$title}}</u>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="1" class="name-data">
                    Código:
                </td>
                <td colspan="3" class="data-value codigo-value">
                    {{1000000 + $garantia->idGarantia}}
                </td>
                <td colspan="2" class="text-end data-value">
                    {{$garantia->fechaGarantia->translatedFormat('l j F Y')}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="section-header">
                    Datos Cliente
                </td>
                <td colspan="4" style="background: #f8fafc !important;">
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Nombres:
                </td>
                <td colspan="5" class="data-value">
                    {{$garantia->Cliente->nombre . ' ' . $garantia->Cliente->apellidoPaterno . ' ' . $garantia->Cliente->apellidoMaterno}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    {{$garantia->Cliente->TipoDocumento->descripcion}}:
                </td>
                <td colspan="2" class="data-value">
                    {{$garantia->Cliente->numeroDocumento}}
                </td>
                <td colspan="1" class="name-data">
                    Celular:
                </td>
                <td colspan="2" class="data-value">
                    {{$garantia->Cliente->telefono}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Número de Comprobante:
                </td>
                <td colspan="4" class="data-value">
                    {{$garantia->numeroComprobante}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="section-header">
                    Datos Producto
                </td>
                <td colspan="4" style="background: #f8fafc !important;">
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Marca:
                </td>
                <td colspan="1" class="data-value">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->MarcaProducto->nombreMarca}}
                </td>
                <td colspan="1" class="name-data">
                    Modelo:
                </td>
                <td colspan="3" class="data-value">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->modelo}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Serie:
                </td>
                <td colspan="5" class="data-value">
                    {{$garantia->RegistroProducto->numeroSerie}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="section-header">
                    Componentes Recepcionados
                </td>
            </tr>
            <tr>
                <td colspan="6" class="data-value recepcion-cell">
                    {{$garantia->recepcion}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Estado Físico:
                </td>
                <td colspan="4" class="data-value">
                    {{$garantia->estado}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Falla Presentada:
                </td>
                <td colspan="4" class="data-value falla-cell">
                    {{$garantia->falla}}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="clause-message">
        <strong>NOTA IMPORTANTE:</strong> Una vez notificado que el equipo se encuentra disponible para recojo, el cliente dispone de un plazo máximo de treinta (30) días calendario para retirar el producto. Transcurrido dicho plazo sin que se haya realizado la recogida, la empresa no se hace responsable por la custodia del equipo y podrá disponer del mismo conforme a sus políticas internas.
    </div>

    <div class="footer-wrapper">
        <div class="footerDiv">
            <img src="{{$firma}}" class="firma-empresa" alt="">

            <div class="firma-cliente">
                FIRMA DEL CLIENTE
            </div>
        </div>
    </div>

    <!-- Added visual separator between forms -->
    <div class="form-separator"></div>

    <!-- Second warranty form (duplicate with same improvements) -->
    <table>
        <thead>
            <tr class="header-row">
                <th class="cel-img" colspan="6">
                    <img class="img-cab" src="{{$cabecera}}" alt="Logo de la empresa">
                </th>
            </tr>
            <tr class="title-row">
                <th colspan="6" style="font-size: 12px; font-weight: 700; color: #111827;">
                    <u>{{$title}}</u>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="1" class="name-data">
                    Código:
                </td>
                <td colspan="3" class="data-value codigo-value">
                    {{1000000 + $garantia->idGarantia}}
                </td>
                <td colspan="2" class="text-end data-value">
                    {{$garantia->fechaGarantia->translatedFormat('l j F Y')}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="section-header">
                    Datos Cliente
                </td>
                <td colspan="4" style="background: #f8fafc !important;">
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Nombres:
                </td>
                <td colspan="5" class="data-value">
                    {{$garantia->Cliente->nombre . ' ' . $garantia->Cliente->apellidoPaterno . ' ' . $garantia->Cliente->apellidoMaterno}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    {{$garantia->Cliente->TipoDocumento->descripcion}}:
                </td>
                <td colspan="2" class="data-value">
                    {{$garantia->Cliente->numeroDocumento}}
                </td>
                <td colspan="1" class="name-data">
                    Celular:
                </td>
                <td colspan="2" class="data-value">
                    {{$garantia->Cliente->telefono}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Número de Comprobante:
                </td>
                <td colspan="4" class="data-value">
                    {{$garantia->numeroComprobante}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="section-header">
                    Datos Producto
                </td>
                <td colspan="4" style="background: #f8fafc !important;">
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Marca:
                </td>
                <td colspan="1" class="data-value">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->MarcaProducto->nombreMarca}}
                </td>
                <td colspan="1" class="name-data">
                    Modelo:
                </td>
                <td colspan="3" class="data-value">
                    {{$garantia->RegistroProducto->DetalleComprobante->Producto->modelo}}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="name-data">
                    Serie:
                </td>
                <td colspan="5" class="data-value">
                    {{$garantia->RegistroProducto->numeroSerie}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="section-header">
                    Componentes Recepcionados
                </td>
            </tr>
            <tr>
                <td colspan="6" class="data-value recepcion-cell">
                    {{$garantia->recepcion}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Estado Físico:
                </td>
                <td colspan="4" class="data-value">
                    {{$garantia->estado}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="name-data">
                    Falla Presentada:
                </td>
                <td colspan="4" class="data-value falla-cell">
                    {{$garantia->falla}}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="clause-message">
        <strong>NOTA IMPORTANTE:</strong> Una vez notificado que el equipo se encuentra disponible para recojo, el cliente dispone de un plazo máximo de treinta (30) días calendario para retirar el producto. Transcurrido dicho plazo sin que se haya realizado la recogida, la empresa no se hace responsable por la custodia del equipo y podrá disponer del mismo conforme a sus políticas internas.
    </div>

    <div class="footer-wrapper">
        <div class="footerDiv">
            <img src="{{$firma}}" class="firma-empresa" alt="">

            <div class="firma-cliente">
                FIRMA DEL CLIENTE
            </div>
        </div>
    </div>
</body>
</html>
