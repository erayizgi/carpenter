<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Search Form</title>
</head>
<body>
<form action="/search" method="POST">
    @csrf
    <div class="container">
        <div class="form-group">
            <label class="">Depth</label>
            <select name="depth" id="" class="form-control">
                <option value="60">60mm</option>
                <option value="40">40mm</option>
            </select>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Width</label>
                    <input type="number" min="0" class="form-control" name="width">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Length</label>
                    <input type="number" min="0" class="form-control" name="length">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary btn-block" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
@if (isset($depth))
<div class="container mt-5">
    <div class="row">
        <strong>Search Result</strong>
    </div>
    <div class="row">
        <div class="col">
            Depth: {{ $depth }}
        </div>
        <div class="col">
            Width: {{ $width }}
        </div>
        <div class="col">
            Length: {{ $length }}
        </div>
        <div class="col">
            Price: {{ $price }}
        </div>
    </div>
</div>
@endif
</body>
</html>
