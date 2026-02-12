<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h2>Create a new list</h2>
    <div>
        <form action="/create-list" method="POST">
            @csrf
            <input name="list" type="text" placeholder="Input list here"
            {{ auth()->guest() ? 'disabled' : '' }}>
            <button {{ auth()->guest() ? 'disabled' : '' }}>
                Save List
            </button>
        </form>
    </div>

    <div style="border: 3px solid black">
        <h3>All Lists here</h3>
        @foreach ($posts as $post)
            <div style="border: 3px solid black">

                <h4>{{$post['list']}}</h4>

                {{-- <h4>{{$post['list']}} //by {{$post->user->name}}//</h4> --}}
                <!--untuk melihat siapa yang upload list tersebut ^-->

                <p><a href="/edit-list/{{$post->id}}" {{ auth()->guest() ? 'disabled' : '' }}>Edit</a></p>
                <form action="/delete-list/{{$post->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button {{ auth()->guest() ? 'disabled' : '' }}>
                        Delete
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    @auth
    <form action="/logout" method="POST">
        @csrf
        <button>Logout!</button>
    </form>
    @else
    <a href="/register">
        @csrf
        <button>Register</button>
    </a>
    @endauth
    
    
</body>
</html>