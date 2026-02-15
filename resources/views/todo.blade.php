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
    <header class="flex justify-center items-center h-25 bg-amber-500 pb-3">
        <h1 class="text-2xl">Create a new list</h1>
    </header>
    <section class="relative h-screen w-screen bg-blue-400 min-h-screen max-w-12/12">

        <aside class="absolute bg-emerald-600 w-1/19 h-full">
            <p>hello</p>
        </aside>

        <main class="h-full w-full bg-blue-600 flex items-center justify-center flex-col">
            <h3 class="p-5 text-3xl">All lists here</h3>

            <div style="border: 3px solid black" class="flex items-center bg-red-300 flex-col h-10/12 w-9/12 p-[3%] gap-1 md:gap-2 lg:gap-3">
                <div class="flex justify-center bg-amber-300">
                    <form action="/create-list" method="POST">
                        @csrf
                        <input name="list" type="text" placeholder="New list here"
                        {{ auth()->guest() ? 'disabled' : '' }}>
                        <button {{ auth()->guest() ? 'disabled' : '' }}>
                            Save List
                        </button>
                    </form>
                </div>

                @foreach ($posts as $post)
                    <div style="border: 3px solid rgb(49, 0, 228)" 
                    class="flex justify-between items-center h-2/12 w-10/12 pr-[1%] pl-[1%] rounded-2xl">

                        <h4 class="">{{$post['list']}}</h4>

                        {{-- <h4>{{$post['list']}} //by {{$post->user->name}}//</h4> --}}
                        <!--untuk melihat siapa yang upload list tersebut ^-->
                        <div class="flex justify-between w-1/12">
                            <p><a href="/edit-list/{{$post->id}}" {{ auth()->guest() ? 'disabled' : '' }}>E</a></p>
                            <form action="/delete-list/{{$post->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button {{ auth()->guest() ? 'disabled' : '' }} class="cursor-pointer">
                                    D
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>


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
    </section>
    
    
    
</body>
</html>