<!doctype html>
<html>
    <head>
        @include('includes.head')
        @yield('pagescript')
        @yield('pagecss')
        <style>
            /* 
                1. Para utilizar o menu superior do bootstrap fixo, eh preciso dar um padding-top para
                o conteudo nao ficar atras do menu
            */
            body > .container 
            { 
                padding-top: 70px; 
            }
            /* 
                2. Para manter o conteudo do footer fixo na parte inferior
            */
            html {
                position: relative;
                min-height: 100%;
            }
            body {
                /* Margin bottom by footer height */
                margin-bottom: 30px;
            }
            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                /* Set the fixed height of the footer here */
                height: 30px;
                background-color: #f5f5f5;
            }
            /*
            Solução para não deslocar conteúdo para esquerda ao abrir ou fechar modal
            */
            body { padding-right: 0 !important }

            /*
                Para link com pointer apropriado mesmo sem o 'href'
            */
            a:hover {
                cursor:pointer;
            }
        </style>
    </head>
    <body>

        <div class="container">

            <header class="row">
                @include('includes.header')
            </header>

            <div id="main" class="row">

                @yield('content')



            </div>



        </div>
        <footer class="footer">
            @include('includes.footer')
        </footer>
    </body>
</html>
