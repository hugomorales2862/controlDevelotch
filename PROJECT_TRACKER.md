# Develotech Core CRM - Project State & Tracker

Este documento sirve como un registro vivo de la arquitectura actual del proyecto, los últimos cambios implementados y el flujo de trabajo vigente. **Cualquier inteligencia artificial o desarrollador que trabaje en este código debe leer este archivo antes de comenzar para entender el contexto.**

## 1. Contexto General
- **Proyecto**: Develotech Core
- **Framework**: Laravel (PHP) con Blade y Alpine.js en las vistas
- **Capa Base de Datos**: MySQL (Uso de relaciones estándar y polimórficas de Eloquent)
- **Módulos Principales**: Clientes, Prospectos, Cotizaciones, Reportes Financieros, Auditoría Logs y Gestión de Roles/Permisos.

## 2. Estado Actual de la Arquitectura Comercial (CRM)

### Clientes (`App\Models\Client`)
- Llave primaria personalizada: `cli_id` en lugar de `id`. Siempre debes usar `cli_id` para ruteo o referencias (ej. `$client->cli_id`).
- Usa el trait `HasAuditLog` para registrar los cambios en la tabla de sistema `audit_logs`. (Al ser eliminado físicamente, auditará conservando dependencias).

### Prospectos (`App\Models\Prospect`)
- Posible consumidor comercial. Aún no ha facturado/comprado.
- Posee la función vital `toClient()` que convierte el registro prospecto actual a un registro `Client` formal. Transfiere todos sus datos de contacto y todas sus cotizaciones asociadas usando polimorfismo. Al finalizar se marca automáticamente como status `won` (convertido).

### Cotizaciones (`App\Models\Quote`)
- **¡Importante!** Las cotizaciones son polimórficas. No referencian estáticamente a un `client_id`.
- Utilizan `quoteable_id` y `quoteable_type` vinculándose por polimorfismo (`morphTo()`) ya sea hacia un **Cliente activo** o a un **Prospecto**.
- Sus items (`QuoteItem`) relacionan servicios listados (`Service`) calculando cantidades y sub-totales.

---

## 3. Registro de Cambios Recientes (Changelog)

- **[NUEVO] Polimorfismo en Cotizaciones:** Se eliminó la columna rígida `client_id` en `quotes` migrando a una solución polimórfica.
- **[NUEVO] UI Unificada Cotizador:** Vistas rediseñadas (`quotes/create` y `quotes/edit`) con Alpine.js (`@change="updateQuoteable(...)"`) agrupando Prospectos y Clientes en un solo selector inteligente.
- **[NUEVO] Proceso de Escalamiento / Conversión Comercial:** Se implementó y enganchó lógica de migración automática de datos estructurados para que cuando un Prospecto en el embudo acepte un trato, asuma el rol de Cliente arrastrando intacto su registro histórico comercial (`$prospect->toClient()`).
- **[FIX] Integridad Referencial de AuditLogs:** Se corrigió un error logístico crítico (Violation of Foreign Key) dentro de `App\Traits\HasAuditLog::logAction` que provocaba cierres forzados al eliminar un Cliente, al no poder enrutar correctamente el modelo ya inexistente para registrar la traza. Ahora `client_id = null` audita sin comprometer la cascada DB.
- **[FIX] Bug Doble Codificación JSON en Auditoría:** Se removió un `json_encode` manual que causaba errores fatales (`array_keys()` string given) al recuperar `old_values`. El casting asume el trabajo de decodificación. Además, se re-decodifican en crudo los strings fallidos del pasado para no perder el registro histórico de logs.
- **[NUEVO] Auditoría Total y Personalización Spatie:** Se inyectó globalmente el trait `HasAuditLog` a *todos* los modelos del back-end. Adicionalmente, creamos modelos puente personalizados (`App\Models\Role` y `App\Models\Permission`) para heredar Spatie nativo sumando también la inyección de auditorías automatizada, configurada correctamente en `config/permission.php`.
- **[FIX] Botón Reportes Historial de Pagos:** Se corrigieron los selectores en reportes y vistas, remplazando la propiedad heredada de objeto genérico (`$client->id`) por la llave base de producción de este repositorio específico (`$client->cli_id`).
- **[NUEVO] Regionalización (Guatemala):** Se actualizó el símbolo de moneda de `$` a `Q` (Quetzales) en toda la interfaz (Dashboard, Ventas, Cotizaciones, Facturas, Gastos e Historial de Clientes) para alinearse con los estándares locales del usuario.
- **[NUEVO] Localización Total de Prospectos:** Se eliminó el término anglosajón "Lead" en favor de "Prospecto" en todos los módulos, botones, etiquetas de estado y navegación, garantizando una interfaz 100% en español.
- **[NUEVO] Vista de Detalle de Prospectos:** Se creó la vista faltante `prospects.show`, resolviendo el error de "View not found". Ahora es posible ver la información completa y el historial de cotizaciones de un prospecto antes de convertirlo.
- **[NUEVO] Ciclo de Vida y Automatización CRM:** 
    - Se implementó la **Expiración Automática** de cotizaciones basada en la fecha de validez (Just-in-Time).
    - Se integró la **Auto-Conversión de Prospectos**: Al aprobar una cotización de un prospecto, el sistema lo promueve automáticamente a Cliente Real.
    - Se añadió la capacidad de **Notificación (`Notifiable`)** a los prospectos para el envío directo de propuestas por correo.
- **[MEJORA] Experiencia de Usuario (SweetAlert2):** Se eliminaron todas las alertas nativas (`confirm`/`alert`) de JavaScript en el módulo de cotizaciones, sustituyéndolas por diálogos modernos de SweetAlert integrados globalmente en el layout.
- **[NUEVO] Gestión de Vida de Registros:** Se añadieron botones de eliminación asistida (con confirmación premium) en el listado y detalle de cotizaciones.



---

## 4. Próximos Pasos (Next Milestones) / A continuar:
1. _A completar en la próxima iteración_: Monitorear la compatibilidad y consistencia de los reportes unificados tras la inyección del modelo de Facturación Electrónica si fuese requerido.
2. Validar o expandir notificaciones por correo (`QuoteSent`) dependiendo de qué entidad polimórfica (Prospect o Client) reciba una orden.

> **Instrucciones para la IA**: Al reanudar las sesiones, toma este documento como la base de la verdad actual de la base de datos y evita re-hacer migraciones o revertir las relaciones polimórficas de `quoteable_type`. Añade cualquier cambio futuro de gran formato a la sección "Registro de Cambios Recientes" de este mismo archivo.
