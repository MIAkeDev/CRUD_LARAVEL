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
        <tbody>
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
    
</body>
</html>