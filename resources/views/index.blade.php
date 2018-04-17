<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 400;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }

            .links {
                color: #636b6f;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Downloader
                </div>
                <div class="container links">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="form" action="{{ route('task.create') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="link" type="text" class="form-control" placeholder="Paste link for download here" aria-describedby="basic-addon">
                                        <span class="input-group-addon" id="basic-addon" style="padding: 0"><button type="submit" class="btn btn-primary">Download</button></span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12">
                            <h3>Tasks</h3>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->link }}</td>
                                            <td>
                                                @if($task->status == 'completed')
                                                    <span class="label label-success">Completed</span>
                                                @elseif($task->status == 'in progress')
                                                    <span class="label label-primary">In progress</span>
                                                @elseif($task->status == 'pending')
                                                    <span class="label label-warning">Pending</span>
                                                @else
                                                    <span class="label label-danger">{{ $task->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->status == 'completed')
                                                    <a href="{{ $task->file_url }}" target="_blank"><span class="text-primary">View file</span></a>
                                                @else
                                                    <span class="text-danger">Not ready yet!</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
