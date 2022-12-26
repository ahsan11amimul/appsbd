<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="com-md-8">
                <h5 class="text-muted text-center">Pending Orders are waiting for approval</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">status</th>
                            <th scope="col">total</th>
                            <th scope="col">discount</th>
                            <th scope="col">action</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->total }}</td>
                                <td>
                                    <form action="{{ url('update') }}" method="post">
                                        @csrf
                                        <input type="text" class="form-control" name="discount"
                                            value="{{ $item->discount ? $item->discount : 0 }}" id="">
                                        <input type="hidden" name="id" value="{{ $item->id }}">

                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
