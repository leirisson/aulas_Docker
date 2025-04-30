<title>@yield('title')</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css')}}">
<!-- Optional theme -->
<!--<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-theme.min.css')}}">-->


<!-- Biblioteca do Jquery jQuery v1.11.3-->
<script src="{{ URL::asset('js/jquery.min.js')}}"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="{{ URL::asset('js/bootstrap.min.js')}}"></script>

<!-- css do vendors -->
<link href="{{ URL::asset('vendors/bootstrap-datepicker-1.6.1/css/bootstrap-datepicker.css')}}" rel="stylesheet">
<link href="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/bootstrap-table.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('vendors/font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet">

<!-- Scripts vendors -->
<script src="{{ URL::asset('vendors/bootstrap-datepicker-1.6.1/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/bootstrap-table.js')}}"></script>
<script src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/bootstrap-table-contextmenu.js')}}"></script>
<script src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/locale/bootstrap-table-pt-BR.js')}}"></script>

<!-- Controle de Sessão expirada -->
@if (AutenticacaoHelper::checkAreaComumLogado() || AutenticacaoHelper::checkAreaAdminLogado())
<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre-controle-sessao.js') }}"></script>
@endif

        


