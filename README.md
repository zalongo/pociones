<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## El Problema

<p>Te acaban de contratar para levantar un servicio API para una tienda de pociones, que lleva actualmente
la información de envíos a través de una planilla excel.</p>
<p>Tu misión es pasar esta información a un modelo de datos en MySQL, donde deberás considerar 3 actores principales: clientes (brujas), ventas y pociones con su receta. Cada poción se descompone en ingredientes que también van adjuntos en el excel.</p>
<p>Que tienes que hacer:</p>
<ol>
<li>Un modelo de datos en MySQL que permita el almacenamiento de clientes, ventas, pociones y
sus recetas.</li>
<li>Una API en Laravel (6.x o superior) con 1 CRUD de una de las entidades antes mencionadas
(clientes, ventas, pociones o recetas)</li>
</ol>
<p>Esta API deberá tener un método de autentificación (a tu elección), no te solicitamos la creación
de usuarios pero si el retorno de un token que autorice el uso de la API al llamar a este método y
sin el token se deberá retornar un mensaje de acceso denegado como respuesta.</p>
<p>Ej: llamada en get al método api/loginApi que retorne el token a utilizar para el resto de los
servicios.</p>

## Consideraciones

<p>Los ingredientes y su costo se encuentran en Excel en la carpeta SCRIPTS.</p>
<p>Parte del desafió es procesar la data y traspasarla a un modelo relacional en MySQL</p>
<p>Todas las respuestas y parámetros de consulta deben manejarse en JSON</p>
<p>El token debe tener un tiempo de vida de 3 horas.</p>

## Solución

<p>La creación de la base de datos ser realizó mediante migraciones.</p>
<p>Se ordenó la data directamente en el archivo excel, generando ahí mismo las consultas de inserción.</p>
<p>Por como estaba ordenada la data en el archivo excel, se asumió que cada venta se relaciona únicamente con una poción cambiando sólo la cantidad.</p>
<p>Se implementó una API para gestionar la venta de pociones.</p>
<p>Para la gestión del token se utilizó Sanctum</p>
<p>Se agregó adicionalmente el stock de los ingredientes. Se agrego un estado para los clientes, ventas, pociones e ingredientes, con la finalidad de no eliminar los datos. Además, se agregaron filtros de clientes y pociones en la consulta a la tabla de ventas.</p>

## Comentarios

<p>En la carpeta /SCRIPTS se encuentra el archivo posiones.sql el cual permite crear y cargar la data en la base de datos. De todos modos, se puede implementar la base de datos con toda la info cargada mediante migrations y seeders con el comando:<br>
<code>php artisan migrate --seed</code>
</p>
<p>En la carpeta /SCRIPTS/requests se encuentran los archivos que permiten realizar las consultas a los distintos endpoints. Estos archivos funcionan con el plugin "REST Client" por Huachao Mao para VSCode.</p>

## End Points

<dl>
	<dt>Login</dt>
	<dd><code>POST /api/auth/login</code></dd>
	<dt>Params</dt>
	<dd>{"email": "user@heyfoodie.cl", "password": "12345678"}</dd>
	<dt>Return</dt>
	<dd>Token</dd>
</dl>
<hr>

<dl>
	<dt>Logout</dt>
	<dd><code>POST /api/auth/logout</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>Confirmation Message</dd>
</dl>
<hr>

<dl>
	<dt>User</dt>
	<dd><code>GET /api/user</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>User Data</dd>
</dl>
<hr>

<dl>
	<dt>Get Clients</dt>
	<dd><code>GET /api/clients</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>All clients</dd>
</dl>
<hr>

<dl>
	<dt>Show Client</dt>
	<dd><code>GET /api/clients/{client_id}</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>Client Data</dd>
</dl>
<hr>

<dl>
	<dt>Store Client</dt>
	<dd><code>POST /api/clients</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"name": "Guacolda",
			"email": "guacolda@heyfoodie.cl"
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Client Data</dd>
</dl>
<hr>

<dl>
	<dt>Update Client</dt>
	<dd><code>PUT /api/clients/{client_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"name": "Guacolda esposa de Lautaro",
			"email": "guacolda@heyfoodie.cl"
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Client Data</dd>
</dl>
<hr>

<dl>
	<dt>Delete Client (set active to 0)</dt>
	<dd><code>DELETE /api/clients/{client_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message</dd>
</dl>
<hr>

<dl>
	<dt>Get Ingredients</dt>
	<dd><code>GET /api/ingredients</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>All ingredients</dd>
</dl>
<hr>

<dl>
	<dt>Show Ingredient</dt>
	<dd><code>GET /api/ingredients/{ingredient_id}</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>Client Data</dd>
</dl>
<hr>

<dl>
	<dt>Store Ingredient</dt>
	<dd><code>POST /api/ingredients</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"name": "Limón",
			"price": 1200,
			"stock": 500
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Client Data</dd>
</dl>
<hr>

<dl>
	<dt>Update Ingredient</dt>
	<dd><code>PUT /api/ingredients/{ingredient_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
		"name": "Limón",
		"price": 1200,
		"stock": 30
	}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Client Data</dd>
</dl>
<hr>

<dl>
	<dt>Delete Ingredient (set active to 0)</dt>
	<dd><code>DELETE /api/ingredients/{ingredient_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message</dd>
</dl>
<hr>

<dl>
	<dt>Get Potions</dt>
	<dd><code>GET /api/potions</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>All potions</dd>
</dl>
<hr>

<dl>
	<dt>Show Potion</dt>
	<dd><code>GET /api/potions/{potion_id}</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>Potion Data</dd>
</dl>
<hr>

<dl>
	<dt>Store Potion</dt>
	<dd><code>POST /api/potions</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"name": "Agua Para Resfrio",
			"ingredients": [{"ingredient_id": 11,"quantity": 0.3},{"ingredient_id": 12,"quantity": 0.1},{"ingredient_id": 13,"quantity": 0.4}]
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Potion Data</dd>
</dl>
<hr>

<dl>
	<dt>Update Potion</dt>
	<dd><code>PUT /api/potions/{potion_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"name": "Agua Para Resfrio",
			"ingredients": [{"ingredient_id": 11,"quantity": 0.3},{"ingredient_id": 12,"quantity": 0.1}]
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Potion Data</dd>
</dl>
<hr>

<dl>
	<dt>Delete Potion (set active to 0)</dt>
	<dd><code>DELETE /api/potions/{potion_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message</dd>
</dl>
<hr>

<dl>
	<dt>Get Sales</dt>
	<dd><code>GET /api/sales (optional filters ?client_id=1&potion_id=1)</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>All sales</dd>
</dl>
<hr>

<dl>
	<dt>Show Sale</dt>
	<dd><code>GET /api/sales/{sale_id}</code></dd>
	<dt>Params</dt>
	<dd>Authorization: Bearer xxxtokenxxx</dd>
	<dt>Return</dt>
	<dd>Sale Data</dd>
</dl>
<hr>

<dl>
	<dt>Store Sale</dt>
	<dd><code>POST /api/sales</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"client_id": 5,
			"potion_id": 4,
			"quantity": 3
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Sale Data</dd>
</dl>
<hr>

<dl>
	<dt>Update Sale</dt>
	<dd><code>PUT /api/sales/{sale_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx<br>
		{
			"client_id": 5,
			"potion_id": 4,
			"quantity": 2
		}
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message & Sale Data</dd>
</dl>
<hr>

<dl>
	<dt>Delete Sale (set active to 0)</dt>
	<dd><code>DELETE /api/sales/{sale_id}</code></dd>
	<dt>Params</dt>
	<dd>
		Authorization: Bearer xxxtokenxxx
	</dd>
	<dt>Return</dt>
	<dd>Confirmation Message</dd>
</dl>
<hr>
