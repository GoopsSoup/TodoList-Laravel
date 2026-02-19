<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-[#f1f5f9]">
    <header class="flex justify-center items-center h-25 bg-[#4f46e5] pb-3">
        <h1 class="text-2xl">To Do List</h1>
    </header>

    <section class="relative min-h-screen w-screen max-w-12/12">

        <aside class="absolute bg-[#1e293b] w-1/19 h-full">
            <p>hello</p>
        </aside>    

        {{-- Lists --}}
        <main class="h-full w-full  flex items-center justify-center flex-col flex-1">
            <h3 class="p-5 text-3xl">All lists here</h3>


            <div style="border: 3px solid black" class="flex items-center bg-[#f0f0f0] flex-col h-12/12 w-9/12 p-[2%] gap-1 md:gap-2 lg:gap-3">
                
                {{-- Add list --}}
                <div class="flex h-2/12 w-11/12 m-6">
                    <form action="/create-list" method="POST" class="flex w-full justify-between">
                        @csrf
                        <input name="list" type="text" placeholder="Add List Here"
                        {{ auth()->guest() ? 'disabled' : '' }}
                        class="h-full p-1 bg-blue-700 w-12/12 rounded-tl-[20px] rounded-bl-[10px]">
                        <button {{ auth()->guest() ? 'disabled' : '' }} 
                            class="bg-amber-950 rounded-br-[20px] rounded-tr-[10px]">
                            Save List
                        </button>
                    </form>
                </div>

                {{-- lists --}}
                    <div 
                    class="w-12/12  max-h-[65vh] flex flex-col justify-start items-center gap-y-5 bg-slate-200 rounded-2xl shadow-[inset_0_0px_15px_rgba(0,0,0,0.20)] overflow-y-auto pb-10 pt-10
                    custom-scrollbar">
                        @foreach ($posts as $post)
                            <div 
                            class="flex bg-[#faf9f9] justify-between items-center min-h-16 w-11/12 pr-[1%] pl-[1%] rounded-2xl border border-[#d2d2d2] shadow-[0_5px_1px_rgba(0,0,0,0.50)]
                            cards">

                                <div class="relative group flex-1 min-w-0">

                                    <h4 class="text-[1.2rem] p-2 truncate text-[#0f172a]">
                                        {{$post['list']}}
                                    </h4>

                                    <div class="absolute max-w-8/12 mt-1 hidden group-hover:block w-auto bg-gray-700 text-white text-sm p-2 rounded-lg z-50 break-words opacity-70">
                                        {{$post['list']}}
                                    </div>

                                </div>

                                {{-- <h4>{{$post['list']}} //by {{$post->user->name}}//</h4> --}}
                                <!--untuk melihat siapa yang upload list tersebut ^-->

                                <div class="flex justify-between w-1/12">
                                    {{-- Edit list --}}
                                    <p><a href="/edit-list/{{$post->id}}" {{ auth()->guest() ? 'disabled' : '' }}>E</a></p>
                                    {{-- Delete list --}}
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
            </div>
        </main>
    </section>
    
    
    
</body>
</html>