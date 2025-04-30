<!doctype html>
<!-- Este seria um layout utilizado com menus laterais. Descartado por enquanto pois o menu superior
pode conter todas as opções pois o sistema é simples-->
<html>
    <head>
        @include('includes.head')
    </head>
    <body>
        <div class="container">

            <header class="row">
                @include('includes.header')
            </header>

            <div id="main" class="row">

                <!-- sidebar content -->
                <div id="sidebar" class="col-md-4">
                    @include('includes.sidebar')
                </div>

                <!-- main content -->
                <div id="content" class="col-md-8">
                    @yield('content')
                </div>

            </div>

        </div>
        <footer class="footer">
                @include('includes.footer')
        </footer>
    </body>
</html>
