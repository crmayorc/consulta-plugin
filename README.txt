# Consulta Inventario Plugin

Este plugin para WordPress crea y gestiona una tabla de inventario de productos, permitiendo consultar datos de manera visual y formateada. La tabla se crea automáticamente al activar el plugin, y se muestran campos específicos con formatos mejorados para facilitar la lectura y el análisis de los datos.

## Características y Mejoras

1. **Creación Automática de la Tabla:**  
   Al activar el plugin, se crea automáticamente la tabla `wp_productos_inventario` con la estructura correcta.

2. **Visualización de Campos Específicos:**  
   Muestra los campos relevantes de la tabla para que la información sea clara y concisa.

3. **Formato de Precios y Valores:**  
   Los campos `precio` y `valor` se formatean como moneda, incluyendo el símbolo "$".

4. **Formato de Fecha Mejorado:**  
   La fecha se muestra en un formato más legible para facilitar su comprensión.

5. **Ordenamiento de Resultados:**  
   Los resultados se ordenan por fecha de manera descendente, mostrando primero los registros más recientes.

6. **Indicador de Carga:**  
   Se incluye un indicador de carga mientras se consultan los datos, mejorando la experiencia del usuario.

7. **Estilo Mejorado y Mensajes de Error:**  
   La tabla y los mensajes de error cuentan con un estilo optimizado para una mejor visualización.

## Estructura de la Tabla

El plugin creará la siguiente tabla en la base de datos:

```sql
CREATE TABLE wp_productos_inventario (
    codigo INT NOT NULL,
    talla INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    fecha DATETIME NOT NULL,
    PRIMARY KEY (codigo, talla, fecha)
);

Datos de Ejemplo
Para insertar datos de ejemplo, puedes ejecutar las siguientes sentencias SQL a través de phpMyAdmin o cualquier otra herramienta de administración MySQL:

sql
Copiar
INSERT INTO wp_productos_inventario (codigo, talla, cantidad, precio, valor, fecha) VALUES
(2, 34, 7, 14000, 27000, '2020-03-01 15:00:00'),
(2, 34, 5, 14000, 25000, '2020-03-01 18:00:00'),
(2, 34, 1, 14000, 28000, '2020-03-01 19:00:00'),
(2, 35, 3, 14000, 28000, '2020-03-02 04:05:25'),
(2, 34, 1, 14000, 25000, '2020-03-02 04:13:45'),
(2, 35, 1, 14000, 24000, '2020-03-02 12:52:27');

## Instrucciones de Instalación y Uso

**Activar el Plugin:**
- Ingresa al Dashboard de WordPress, dirígete a la sección de Plugins, y activa el plugin "Consulta Inventario Plugin".

**Acceso al Plugin:**
- Una vez activado, encontrarás un nuevo menú llamado "Consulta Inventario" en el Dashboard de WordPress.

**Consultar Datos:**
- Haz clic en el botón "Consultar Datos" dentro del menú para visualizar los registros del inventario, con el formato de precios, valores y fechas mejorados, y ordenados por fecha descendente.




