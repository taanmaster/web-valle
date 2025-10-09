# Indicadores y KPIs de Desarrollo Urbano

## Descripción General

Este módulo proporciona una vista completa de indicadores clave de rendimiento (KPIs) para el departamento de Desarrollo Urbano, permitiendo el monitoreo y análisis de expedientes y citatorios.

## Características Principales

### 1. Filtro de Fechas
- **Fecha Inicio**: Permite seleccionar la fecha inicial del período a analizar
- **Fecha Final**: Permite seleccionar la fecha final del período a analizar
- **Por defecto**: Se muestran los datos desde el inicio del mes actual hasta la fecha actual

### 2. Indicadores de Expedientes

#### Total de Expedientes
Muestra el número total de expedientes creados en el período seleccionado.

#### Estados de Expedientes
- **Expedientes Abiertos**: Expedientes en estados: new, entry, validation, requires_correction, inspection
- **Expedientes Cancelados**: Expedientes con estado 'cancelled'
- **Expedientes Cerrados**: Expedientes con estado 'resolved'
- **Expedientes a Corrección**: Expedientes con estado 'requires_correction'

#### Tipos de Licencias/Permisos
Contabiliza los expedientes por tipo:
1. **Licencia de Uso de Suelo** (uso-de-suelo)
2. **Constancia de Factibilidad** (constancia-de-factibilidad)
3. **Permiso de Anuncios y Toldos** (permiso-de-anuncios)
4. **Constancia de Alineamiento** (certificacion-numero-oficial)
5. **Permiso de División** (permiso-de-division)
6. **Uso de Vía Pública** (uso-de-via-publica)
7. **Licencia de Construcción** (licencia-de-construccion)
8. **Permiso de Construcción en Panteones** (permiso-construccion-panteones)

#### Tiempo Promedio de Cierre
Calcula el promedio de días transcurridos desde la creación hasta el cierre (resolved) de los expedientes en el período seleccionado.

#### Asignación de Expedientes
Muestra un desglose de expedientes asignados a cada inspector, con un gráfico circular (placeholder) y badges de colores para cada inspector.

### 3. Indicadores de Citatorios

#### Total de Citatorios
Muestra el número total de citatorios (expedientes con fecha de inspección) en el período seleccionado.

#### Estados de Citatorios
- **Citatorios Abiertos**: Citatorios en estado 'inspection'
- **Citatorios Cerrados**: Citatorios con estado 'resolved'
- **Citatorios a Suspensión**: Citatorios con estado 'cancelled'

#### Tiempo Promedio de Citatorio
Calcula el promedio de días desde la fecha de inicio de inspección hasta el cierre del citatorio.

#### Tasa de Suspensión
Porcentaje de citatorios que terminaron en suspensión (cancelled) respecto al total de citatorios.

#### Citatorios por Inspector
Similar a la asignación de expedientes, muestra la distribución de citatorios por inspector.

## Base de Datos

### Tabla: urban_dev_requests

Campos principales utilizados en los KPIs:
- `created_at`: Fecha de creación del expediente
- `updated_at`: Fecha de última actualización
- `status`: Estado del expediente
  - new: Nuevo
  - entry: Ingreso
  - validation: Validación
  - requires_correction: Requiere Corrección
  - inspection: Inspección
  - resolved: Resuelto
  - cancelled: Cancelado
- `request_type`: Tipo de licencia/permiso
- `inspector_id`: ID del inspector asignado
- `inspection_start_date`: Fecha de inicio de inspección (para citatorios)

## Rutas

- **URL**: `/urban-dev/kpis`
- **Nombre**: `urban-dev.kpis.index`
- **Método**: GET
- **Controlador**: `UrbanDevKPIsController@index`

## Parámetros de Consulta

- `start_date` (opcional): Fecha de inicio en formato Y-m-d
- `end_date` (opcional): Fecha final en formato Y-m-d

Ejemplo: `/urban-dev/kpis?start_date=2025-01-01&end_date=2025-01-31`

## Validaciones

- Las fechas son validadas en el frontend y backend
- Se asegura que la fecha final no sea anterior a la fecha de inicio
- Los cálculos de porcentajes manejan divisiones por cero