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
            padding: 6px; /* Reduced padding from 8px to 6px for better A4 fit */
            background: #ffffff;
            color: #1f2937;
            line-height: 1.3; /* Reduced line height from 1.4 to 1.3 for compactness */
            font-size: 10px;
        }
        
        /* Strict A4 page constraints */
        @page {
            size: A4;
            margin: 0.4cm; /* Reduced margin from 0.5cm to 0.4cm */
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 6px; /* Reduced margin from 8px to 6px */
            border-radius: 3px; /* Smaller border radius from 4px to 3px */
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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
            font-size: 10px;
            border: 1px solid #9ca3af; /* Slightly darker gray border */
            padding: 3px 5px; /* Reduced padding from 4px 6px to 3px 5px */
            background-color: #ffffff;
            width: calc(100% / 6);
            vertical-align: middle;
        }
        
        th {
            background: #e5e7eb; /* Changed to neutral gray */
            font-weight: 700;
            text-align: center;
            color: #111827; /* Darker text color */
        }
        
        .name-data {
            font-weight: 700;
            font-size: 10px !important;
            color: #111827; /* Darker text color */
            background: #e5e7eb !important; /* Changed to neutral gray */
        }
        
        .data-value {
            background: #ffffff !important;
            color: #111827;
            font-weight: 500;
            font-size: 10px;
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
        .footerDiv {
            width: 100%;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 12px; /* Reduced margin from 15px to 12px */
        }
        
        /* Fixed signature image size and positioning */
        .firma-empresa {
            width: 120px;
            height: 50px;
            object-fit: contain;
            margin-right: 20px;
        }
        
        .firma-cliente {
            border-top: 2px solid #111827; /* Changed to dark gray */
            width: 150px;
            text-align: center;
            padding-top: 5px; /* Reduced padding from 6px to 5px */
            font-weight: 700;
            color: #111827;
            font-size: 9px;
            flex-shrink: 0;
        }
        
        .form-separator {
            text-align: center;
            margin: 30px 0; /* Reduced margin from 40px to 30px */
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
            background: #e5e7eb !important; /* Changed from purple to neutral gray */
            font-weight: 700;
            color: #111827;
            letter-spacing: 0.5px;
            font-size: 11px;
        }
        
        .compact-row td {
            padding: 2px 4px !important; /* Reduced padding from 2px 5px to 2px 4px */
        }
        
        /* Enhanced print optimization for A4 */
        @media print {
            body {
                padding: 3px; /* Reduced padding from 4px to 3px */
                font-size: 7px;
            }
            
            .form-separator {
                page-break-inside: avoid;
                margin: 8px 0; /* Reduced margin from 10px to 8px */
            }
            
            table {
                page-break-inside: avoid;
                box-shadow: none;
                margin-bottom: 4px; /* Reduced margin from 6px to 4px */
            }
            
            .footerDiv {
                margin-top: 6px; /* Reduced margin from 8px to 6px */
                height: 45px; /* Reduced height from 50px to 45px */
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
                <td colspan="6" class="data-value" style="min-height: 30px; padding: 8px;">
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
                <td colspan="4" class="data-value" style="min-height: 25px;">
                    {{$garantia->falla}}
                </td>
            </tr>
        </tbody>
    </table>
    
    <div class="footerDiv">
        <img src="{{$firma}}" style="width: 150px" alt="">
 
        <div class="firma-cliente">
            FIRMA DEL CLIENTE
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
                <td colspan="6" class="data-value" style="min-height: 30px; padding: 8px;">
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
                <td colspan="4" class="data-value" style="min-height: 25px;">
                    {{$garantia->falla}}
                </td>
            </tr>
        </tbody>
    </table>
    
    <div class="footerDiv">
        <img src="{{$firma}}" style="width: 150px" alt="">

        <div class="firma-cliente">
            FIRMA DEL CLIENTE
        </div>
    </div>
</body>
</html>
