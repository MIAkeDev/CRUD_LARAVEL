<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de productos</title> 
</head>
<body>
    <h1>Gestión de productos</h1>
    <a href="{{ route('products.create')}}">
        <button>+ Crear un nuevo producto</button>
    </a>

    <button id="btnActualizarApi" style="margin-left: 10px; background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
        Actualizar con API
    </button>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categorías</th>
                <th>Acciones</th>
            </tr>    
        </thead>
        <tbody id="tbody-productos">
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>        
                <td>{{ $product->name }}</td>
                <td>{{ $product->formatted_price}}</td>
                <td>{{ $product->category->name }}</td>

                <td>
                    <a href="{{ route('products.edit', $product->id)}}"> Editar </a>
                    <form action={{ route('products.destroy', $product->id)}} method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                            X
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        document.getElementById('btnActualizarApi').addEventListener('click', function(){
            let boton = this;
            boton.innerText = 'Cargando...';
//LISTAR 
            fetch('/api/products')
                .then(response => response.json())
                .then(result => {
                    console.log("Respuesta cruda de la API:", result);
                    if (result.success){
                        let tbody = document.getElementById('tbody-productos');
                        tbody.innerHTML = '';
                        result.data.forEach(product => {
                            let tr = document.createElement('tr');
                            let categoria = product.category ? product.category.name : 'Sin categoría';

                            tr.innerHTML=`
                                <td>${product.id}</td>
                                <td>${product.name}</td>
                                <td><strong>${product.formatted_price}</strong></td>
                                <td>${categoria}</td>
                                <td>
                                    <a href="/products/${product.id}/edit"> Editar </a>
                                    <form action="/products/${product.id}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                            X
                                        </button>
                                    </form>
                                </td>
                            `;
                            tbody.appendChild(tr);

                        });
                        boton.innerText = 'Actualizar con API';
                    }
                })
                .catch(error => {
                    console.error('Error de API', error);
                    alert('Hubo un problema de conexión con el servidor.');
                    boton.innerText = 'Actualizar con API'
                });
        });
    </script>
    
</body>
</html>