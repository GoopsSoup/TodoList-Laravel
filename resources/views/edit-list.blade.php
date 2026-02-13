<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    <h1>Edit List</h1>
    <form action="/edit-list/{{$post->id}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="list" value="{{$post->list}}">
        <button>Save changes</button>
    </form>
</body>
</html>