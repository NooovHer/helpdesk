# Sistema de Estado del Sistema

## Descripción

El sistema de estado del sistema permite a administradores y agentes gestionar y mostrar el estado actual de los diferentes servicios del sistema de helpdesk. Los usuarios pueden ver en tiempo real si hay problemas o mantenimiento programado.

## Características

- **Estados disponibles:**
  - 🟢 **Operativo**: Todo funciona correctamente
  - 🟡 **Degradado**: Funcionalidad limitada o lenta
  - 🔴 **Fuera de Servicio**: Servicio no disponible
  - 🔵 **Mantenimiento**: Mantenimiento programado

- **Funcionalidades:**
  - Gestión completa de servicios (CRUD)
  - Actualización rápida de estados
  - Descripciones detalladas de problemas
  - Historial de actualizaciones
  - Interfaz intuitiva para administradores y agentes

## Uso

### Para Administradores y Agentes

1. **Acceder a la gestión:**
   - Desde el dashboard principal: Botón "Gestionar" en la sección de Estado del Sistema
   - Desde el dashboard de administrador: Enlace "Estado del Sistema" en accesos rápidos
   - URL directa: `/admin/system-status`

2. **Gestionar servicios:**
   - **Crear nuevo servicio**: Botón "Agregar Servicio"
   - **Editar servicio**: Botón "Editar" en la tabla
   - **Actualización rápida**: Botón "Actualizar" para cambios rápidos
   - **Eliminar servicio**: Botón "Eliminar" (con confirmación)

3. **Actualización rápida:**
   - Modal que permite cambiar estado y descripción sin salir de la página
   - Actualización en tiempo real sin recargar la página

### Para Usuarios

- **Ver estado actual**: Sección "Estado del Sistema" en el dashboard principal
- **Información detallada**: Descripciones de problemas o mantenimiento
- **Indicadores visuales**: Colores y animaciones según el estado

## Estructura de Base de Datos

```sql
CREATE TABLE system_statuses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(255) NOT NULL,
    status ENUM('operational', 'degraded', 'outage', 'maintenance') DEFAULT 'operational',
    description TEXT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Rutas Disponibles

### Administradores y Agentes
- `GET /admin/system-status` - Lista de servicios
- `GET /admin/system-status/create` - Formulario de creación
- `POST /admin/system-status` - Crear servicio
- `GET /admin/system-status/{id}/edit` - Formulario de edición
- `PUT /admin/system-status/{id}` - Actualizar servicio
- `DELETE /admin/system-status/{id}` - Eliminar servicio
- `POST /admin/system-status/{id}/quick-update` - Actualización rápida (AJAX)

## Componentes

### SystemStatusWidget
Componente reutilizable para mostrar el estado del sistema:

```blade
<x-system-status-widget :showManageButton="true" />
```

**Propiedades:**
- `showManageButton`: Boolean - Muestra el botón de gestión (solo para admin/agent)

## Modelo SystemStatus

### Atributos
- `service_name`: Nombre del servicio
- `status`: Estado actual (operational, degraded, outage, maintenance)
- `description`: Descripción opcional del estado
- `last_updated`: Timestamp de la última actualización

### Accessors
- `status_color`: Color CSS para el estado
- `status_text`: Texto en español del estado
- `status_icon`: Icono FontAwesome del estado

## Personalización

### Agregar nuevos estados
1. Modificar el enum en la migración
2. Actualizar el modelo `SystemStatus` con los nuevos colores, textos e iconos
3. Actualizar las vistas para incluir las nuevas opciones

### Modificar servicios por defecto
Editar el archivo `database/seeders/SystemStatusSeeder.php` para cambiar los servicios iniciales.

## Seguridad

- Solo administradores y agentes pueden modificar el estado
- Validación de datos en el servidor
- Confirmación para eliminación de servicios
- Logs de cambios (futura implementación)

## Futuras Mejoras

- [ ] Notificaciones automáticas cuando cambia el estado
- [ ] Historial de cambios con timestamps
- [ ] Programación de mantenimiento
- [ ] Integración con monitoreo externo
- [ ] API para consultas externas
- [ ] Dashboard de métricas de tiempo de actividad 
