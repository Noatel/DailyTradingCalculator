<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Daily Trading Calculator
                </div>

                <form action="">
                    <div class="links mx-auto">
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                    </div>
                                    <input type="text" id="startingCapital" name="startingCapital" class="form-control" placeholder="Enter starting capital" aria-label="startingCapital" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">%</span>
                                    </div>
                                    <input type="text" id="interest" name="interest" class="form-control" placeholder="Interest" aria-label="Interest" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="maxDays" name="maxDays" placeholder="Max days" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <button type="button" id="submit" class="btn btn-light">Calculate</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <div class="spinner-border" id="loadingDiv" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>

                        <table class="table" id="profitTable">
                            <thead>
                            <tr>
                                <th scope="col">Days</th>
                                <th scope="col">Capital</th>
                                <th scope="col">Amount you need</th>
                            </tr>
                            </thead>
                            <tbody id="addRows">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $( document ).ready(function (){
                $('#loadingDiv').hide();
                $('#profitTable').hide();

                $("#submit").click(function (){
                    $('#loadingDiv').show();

                    var startingCapital = $("#startingCapital").val();
                    var interest = $("#interest").val();
                    var maxDays = $("#maxDays").val();
                    $.ajax({
                        type: 'post',
                        url: '/calculate',
                        data: {
                            'startingCapital': startingCapital,
                            'interest': interest,
                            'maxDays': maxDays,
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(data)
                        {
                            $('#addRows').html('');
                            for(i = 0; i < data.length; i++){
                            $('#addRows').append('<tr>\n' +
                                '<th scope="row">'+ data[i][0] +'</th>\n' +
                                '<td>'+ data[i][1] +'</td>\n' +
                                '<td>'+ data[i][2]+'</td>\n' +
                                '</tr>');
                            }

                            $('#loadingDiv').hide();
                            $('#profitTable').show();
                            console.log(data);
                        },
                    });
                });
            });

        </script>
    </body>
</html>
