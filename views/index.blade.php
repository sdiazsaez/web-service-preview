<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Roboto', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="container" style="padding: 30px 0px;">
    <div class="row">
        <div class="col-3">
            <div>
                <h3>Proveedor</h3>
                @includeWhen(isset($providers), 'larangular.web-service-preview::services-list', ['routes' => $providers])
            </div>
            <div>
                <h3>Servicios</h3>
                @includeWhen(isset($services), 'larangular.web-service-preview::services-list', ['routes' => $services])
            </div>

            @isset($response)
                <div>
                    <h3>Solicitud XML</h3>
                    <div class="form-group">
                        {{ d($response->getServiceClient()->getLastRequest()) }}
                    </div>
                </div>
            @endisset
            @isset($response)
                <div>
                    <h3>Respuesta XML</h3>
                    <div class="form-group">
                        {{d($response->getServiceClient()->getLastResponse())}}
                    </div>
                </div>
            @endisset

            @isset($raw['formatrequest'])
                <div>
                    <h3>Solicitud</h3>
                    <div class="form-group">
                        {{ d($raw['formatrequest']) }}
                    </div>
                </div>
            @endisset

        </div>
        <div class="col-5">
            <h3>{{ $descriptor->provider() }} - {{ $descriptor->serviceName() }}</h3>
            @isset($service['description'])
                <p>{{ $service['description'] }}</p>
            @endisset

            @includeWhen(isset($form), 'larangular.web-service-preview::assets.form.index', compact('form'))
        </div>
        <div class="col">
            @isset($headers)
                <div>
                    <h3>Cabeceras retornadas</h3>
                    {{ d($headers) }}
                </div>
            @endisset
            @isset($response)
                <div>
                    <h3>Respuesta</h3>
                    {{ d($response) }}

                    <h3>Respuesta JSON</h3>
                    <textarea class="form-control" rows="9">
                            {{ json_encode($response) }}
                        </textarea>
                </div>
            @endisset
        </div>
    </div>
</div>
</body>
</html>
