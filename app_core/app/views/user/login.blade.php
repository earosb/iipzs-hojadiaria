{{-- skipmin --}}
<!--                                                                                                                           -->
<!--                                                                                                                           -->
<!--                                 .---._                                                                                    -->
<!--                             .--(. '  .).--.      . .-.                                                                    -->
<!--                          . ( ' _) .)` (   .)-. ( ) '-'                                                                    -->
<!--                         ( ,  ).        `(' . _)                                                                           -->
<!--                       (')  _________      '-'                                                                             -->
<!--                       ____[_________]                     &&&&&&&&                          _______________               -->
<!--                       \__/ | _ \  ||      ,;,;,,        &&&&&&&&&&&&                       [_______________]              -->
<!--                       _][__|(")/__||    ,;;;;;;;;,     &&&&&&&&&&&&&&      ########        _|     2609    |_              -->
<!--                      /             |   |____      |   |    earosb    |   |##########|     |      ____       |             -->
<!--                     (| .--.    .--.|   |     ___  |   |   |      |   |   |##########|     |____             |             -->
<!--                     /|/ .. \~~/ .. \=+=|_.-.__.-._|=+=|_.-:______:-._|=+=|_.-.__.-._|==+==|_.-.___.-.___.-._|             -->
<!--                  +=/_|\ '' /~~\ '' /    ( o )( o )     ( o )    ( o )     ( o )( o )       ( o ) ( o ) ( o )              -->
<!--      ==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-==-=     -->
<!--                                                                                                                           -->
<!--                                                                                                       CC Eduardo Aros     -->
<!--                                                                                                                           -->
@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de login">
    <meta name="author" content="earosb">
@stop

@section('title')
    Iniciar Sesión
@stop
@section('css')
    {{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.6/animate.min.css') }}
    <style type="text/css">
        .well.login-box {
            width: 300px;
            margin: 0 auto;
        }

        .well.login-box legend {
            font-size: 26px;
            text-align: center;
            font-weight: 300;
        }

        .well.login-box input[type="text"] {
            border-color: #ddd;
            border-radius: 0;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div id="divForm" class="col-xs-12 col-md-12" style="display: none;">
            <div style="text-align: center; margin-bottom: 10px;">
                <img alt="Icil-Icafal PZS" src="{{ asset('img/logo.png') }}" width="290px" height="89px">
            </div>
            <div class="well login-box">
                {{ Form::open(array('url' => 'login')) }}
                <legend>{{ trans('form.signin'); }}</legend>
                @if($errors->has('login'))
                    <div class="alert alert-dismissable alert-danger animated shake">
                        <p class="text-center"><strong>{{ $errors->first('login', ':message') }}</strong></p>
                    </div>
                @endif
                <div class="form-group">
                    {{ Form::label('username', trans('form.username')) }}
                    {{ Form::text('username', '', array('class' => 'form-control', 'placeholder' => 'Ingrese Usuario', 'required' => 'required')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('password', trans('form.password')) }}
                    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Ingrese Contraseña', 'required' => 'required')) }}
                </div>
                <div class="form-group text-center">
                    {{ Form::submit(trans('form.signin'), array('class'=>'btn btn-success btn-login-submit')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var form = $('#divForm');
            form.show();
            form.addClass('animated pulse');
        });
    </script>
@stop