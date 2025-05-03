<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   
     @vite(['resources/css/app.css']) 

     <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilos-tablas.css')}}">   
    <link rel="stylesheet" href="{{asset('css/estilos-formularios.css')}}">
    
    
</head>

<body>
  <!-- slidebar   -->
   <aside class="slidebar" id="slidebar">
   
    <a href="{{ route('panel.inicio') }}" class="logo">
        <p class="logo-text">Vanity and Magic</p>
      </a>
      <div class="element-slidebar">
    <!-- PERFIL -->
    {{-- <div class="element-slidebar">
        <div class="element-slidebar-btn profile">
         <span><img src="{{asset('img/face3.png')}}" alt="avatar"></span>
         <p>{{ Auth::user()->name }}</p>
        </div>
        <div class="element-slidebar-content">
            <a href="{{route('profile.edit')}}">Perfil</a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
               <input type="submit" value="Salir" class="logout-link">

             </form>

        </div>
    </div> --}}

    <!-- Inicio -->

        <a href="{{ route('panel.inicio') }}" class="element-slidebar">
            <div class="element-slidebar-btn">
                {{-- <span><img  src="{{asset('img/category.png')}}" alt="Product"></span> --}}
              Panel de Inicio
            </div>
        </a>

     <!-- Categorias -->

        <a href="{{ route('categorias.index') }}" class="element-slidebar">
            <div class="element-slidebar-btn">
                {{-- <span><img  src="{{asset('img/category.png')}}" alt="Product"></span> --}}
              Categorias
            </div>
          </a>
          

    <!-- SubCategorias -->

        <a href="{{ route('subcategorias.index') }}" class="element-slidebar">
         <div class="element-slidebar-btn">
             {{-- <span><img  src="{{asset('img/category.png')}}" alt="Product"></span> --}}
           Subcategorias
         </div>
        </a>
      
    <!-- Productos -->
        
        <a href="{{ route('productos.index') }}" class="element-slidebar">
           <div class="element-slidebar-btn">
               {{-- <span><img  src="{{asset('img/rokrt.png')}}" alt="Product"></span> --}}
             Productos
           </div>
        </a>
               
    <!-- Provedores -->

      <a href="{{ route('proveedores.index') }}" class="element-slidebar">
        <div class="element-slidebar-btn">
            {{-- <span><img  src="{{asset('img/category.png')}}" alt="Product"></span> --}}
          Proveedores
        </div>
      </a>
       
    <!-- Ingresos -->

    <a href="{{ route('ingresos.index') }}" class="element-slidebar">
      <div class="element-slidebar-btn">
          {{-- <span><img  src="{{asset('img/category.png')}}" alt="Product"></span> --}}
        Ingresos / Compras
      </div>
    </a>


    <!-- Egresos -->
    <a href="{{ route('egresos.index') }}" class="element-slidebar">
      <div class="element-slidebar-btn">
          {{-- <span><img  src="{{asset('img/category.png')}}" alt="Product"></span> --}}
        Egresos / Ventas
      </div>
    </a>
 
       
        <!-- Ventas -->
        
            {{-- <div class="element-slidebar-btn"> --}}
             {{-- <span><img  src="{{asset('img/ventas.png')}}" alt="ventas"></span> --}}
             {{-- <a href="{{route('categoria.index')}}">Ventas</a> --}}
            {{-- </div> --}}
      </div>
   </aside>

   <!-- main -->
   <main class="main">
    <!-- header -->
    <header class="header">
        <div class="titulo-nav">@yield('titulomain')</div>  

        <button id="menu-toggle" class="menu-hamburger">☰</button>
    </header>
    {{-- aqui se coloca todos los elmentos cambiantes --}}
      
      @yield('contenido')

   </main>
   
    <script src="{{asset('js/script.js')}}"></script>
</body>
</html>