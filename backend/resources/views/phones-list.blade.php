<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Megahack - phones list</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

   {{--<!-- Styles -->--}}
    {{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
    {{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>--}}
    {{--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>--}}
    {{--<!------ Include the above in your HEAD tag ---------->--}}

    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--}}
    {{--<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>--}}





    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>

    </style>
</head>
<body class="container">
<div id="header"></div>
<div class="flex-center position-ref full-height">
    {{--@if (Route::has('login'))--}}
        {{--<div class="top-right links">--}}
            {{--@auth--}}
                {{--<a href="{{ url('/home') }}">Home</a>--}}
            {{--@else--}}
                {{--<a href="{{ route('login') }}">Login</a>--}}
                {{--<a href="{{ route('register') }}">Register</a>--}}
            {{--@endauth--}}
        {{--</div>--}}
    {{--@endif--}}

    <div class="content">
        <div class="title m-b-md">


                <div class="row">


                    <div class="col-md-12">
                        <h4 class="text-center">Adauga un telefon in cos!</h4>
                        <div class="table-responsive">


                            <table id="mytable" class="table table-bordred table-striped">

                                <thead>

                                <th>Nume Produs</th>
                                <th>Nume</th>
                                <th>Producator</th>
                                <th>Caracteristici</th>
                                <th>Diagonala Ecran</th>
                                <th>Camera</th>
                                <th>Memorie interna</th>
                                <th>Adauga</th>
                                </thead>
                                <tbody>
                                @foreach ($phones as $phone)
                                <tr id="phone-id-{{$phone->id}}">
                                    <td>{{$phone->nume_produs}}</td>
                                    <td>{{$phone->name}}</td>
                                    <td>{{$phone->producator}}</td>
                                    <td>{{$phone->caracteristici_principale}}</td>
                                    <td>{{$phone->diagonala_ecran}}</td>
                                    <td>{{$phone->camera}}</td>
                                    <td>{{$phone->memorie_interna}}</td>
                                    <td>
                                        <p data-placement="top" data-toggle="tooltip" title="Adauga in cos">
                                            <button class="btn btn-primary btn-xs" data-title="Add" data-id-phone="{{$phone->id}}" data-toggle="modal" data-target="#add" >
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </p>
                                    </td>

                                </tr>
                                @endforeach
                                </tbody>

                            </table>

                            <div class="clearfix"></div>

                        </div>

                    </div>
                </div>
        </div>


        <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control " type="text" placeholder="Mohsin">
                        </div>
                        <div class="form-group">

                            <input class="form-control " type="text" placeholder="Irshad">
                        </div>
                        <div class="form-group">
                            <textarea rows="2" class="form-control" placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>


                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>



        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>

        <div class="links">
            <a href="https://laravel.com/docs">Documentation</a>
            {{--<a href="https://laracasts.com">Laracasts</a>--}}
            {{--<a href="https://laravel-news.com">News</a>--}}
            {{--<a href="https://nova.laravel.com">Nova</a>--}}
            {{--<a href="https://forge.laravel.com">Forge</a>--}}
            {{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
        </div>
    </div>
</div>
</body>
</html>

<script>
    $( document ).ready(function() {
        // $("[data-toggle=tooltip]").tooltip();
        var selected_phones = {};
        $('[data-title="Add"]').on('click', function(){
            var selected_phone = $(this).attr('data-id-phone');
            if ( !( selected_phone in selected_phones ) ) {
                selected_phones[selected_phone] = 1;
            }else{
                selected_phones[selected_phone] = selected_phones[selected_phone] + 1;
            }
            var phones = $.map(selected_phones, function( value, key ) {
                return key;
            });

            phones = phones.join(',');
            console.log(phones);
        })




        // var url = "https://www.vodafone.ro/personal/index.htm#tab-1";
        // $.ajax({
        //     crossOrigin: true,
        //     url: url,
        //     success: function(data) {
        //         var text = $(data).find('.tophead \+ div')[0];
        //         $('#header').html(text);
        //     }
        // });

    });
</script>
