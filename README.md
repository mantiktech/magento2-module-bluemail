# Bluemail para Magento 2

## Requerimientos
- PHP **7.X**
- Magento **2.3.X** **2.4.X**

## Instalacion 

```
composer require mantiktech/magento2-module-bluemail`
bin/magento module:enable
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
```

## Actualización 

Para actualizar el modulo a la ultima version (dependiendo de tu `composer.json`), ejecutar los siguientes comandos:

```
composer update mantiktech/magento2-module-bluemail
php bin/magento setup:di:compile
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## Modulo de integraci&oacute;n de la API de Bluemail con Magento 2. 

Si tiene una cuenta comercial con Bluemail, puede ofrecerle a sus clientes la comodidad de elegir Bluemail como su empresa de envíos durante el proceso de pago. Las tarifas se descargan automáticamente, por lo que no es necesario buscar la información.

Antes de poder ofrecer Bluemail a sus clientes, debe completar los siguientes pasos:
1. Establecer el punto de origen de su tienda.
2. Colocar el DNI como requerido. El módulo de Bluemail requiere que se envíe el DNI del cliente. Se debe configurar como requerido (Required) en **Stores > Configuration > Customer Configuration**
Colocar Show Tax/VAT Number como Required
3. Tener productos con peso. Un tema importante es que para que aparezca la opción de envío de Bluemail, los productos del carrito deben tener un peso definido.
4. Configurar y habilitar el módulo de Bluemail.

Habilitar Bluemail para su tienda:
En el Administrador de Magento
TIENDAS> Configuraciones: Configuración> Ventas> Métodos de envío> Bluemail
(**STORES > Settings: Configuration > Sales > Shipping Methods > Bluemail**)

Expanda el selector de expansión en la sección Bluemail.
- Establezca Activado (**Enabled**) para pago en Sí (Yes).
- Seleccione si agrega el cálculo del IVA en el cálculo del costo de envío (**Add IVA to shipping calculation**).
- Ingrese el nombre del método (**Method Name**) de Bluemail (o deje por defecto Bluemail).
- En el cuadro de texto **Sort Order** seleccione el orden de aparición del método de envío con respecto a los otros métodos de envío. El número más bajo aparecerá primero en la lista.
- Ingrese un título (**Title**) para identificar el método de envío de Bluemail durante el pago.

Las siguientes cuatro opciones se utilizan para conectarse en forma de prueba o al sistema productivo (Production) de Bluemail.
**Sandbox Mode = Yes/No**

La URL de la API, el Token y el número de cliente (Customer ID), tanto de sandbox como de producción, son provistos por Bluemail.

Tipo de Envío y Depósito
- Seleccionar el (o los) Tipo de entrega (**Delivery Type** = Send / Pickup) . El tipo de entrega surge del acuerdo que ud realice con Bluemail.
- Seleccionar un depósito en **Deposit / Store**. Si esto no está seleccionado no se verá el método de envío al momento de realizar el pago.

Atributos del paquete
Tienen relación con la configuración de los paquetes a transportar.

Los siguientes selectores se deben asociar a los atributos de altura, ancho y profundidad que se hayan creado para los productos:
* Atributo de altura (**Height Attribute**)
* Atributo de ancho (**Width Attribute**)
* Atributo de profundidad (**Depth Attribute**)

- Unidad de peso (**Weight Unit**), es la unidad de peso utilizada. Se puede seleccionar entre KG (Kilogramos) y LB (Libras).

Alcance de la distribución::
Tienen relación con los países en donde se distribuye la correspondencia.
- Enviar a países que apliquen (**Ship to Applicable Countries**) es una opción que permite seleccionar entre Todos los países permitidos (All Allowed Countries) y Enviar a países específicos (**Specific Countries**). Si se elige esta última opción, habilitará la siguiente lista de múltiple selección con todos los países “Envío o países específicos” (**Ship to Specific Countries**), en la que podrá seleccionar los países donde se realice la distribución.

Mensaje de error mostrado (**Displayed Error Message**) muestra el mensaje de error que se mostrará en pantalla al usuario cuando no se conecta 

Haciendo clic en el link “Bluemail> Enlace de región” (**Bluemail> Region Linking**) muestra una pantalla con las provincias/estados configuradas en Magento y permite asociarlas a la configuración de provincias/estados que tiene Bluemail.

Para grabar la configuración de estas opciones, presionar en el botón “**Save Config**”

## Envíos masivos
Para realizar envíos masivos debe acceder a **Sales > Bluemail Mass Shipping**
Debe seleccionar las órdenes que están pendientes (Pending) y desea enviar. (en el ejemplo de la imagen, las dos primeras órdenes).
Luego debe seleccionar en la lista desplegable ‘**Actions**’ la opción ‘**Create shipments**’ y hacer clic en OK. Se crearán envíos para las órdenes seleccionadas que se pueden observar en la columna Action.
