<!DOCTYPE html>
<html>
<head>
    <title>Task App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        
        <!-- Header & Logout -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Task Manager</h1>
            
            <!-- LOGOUT FORM -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-red-500 underline">
                    Logout
                </button>
            </form>
        </div>

        <!-- Add Task -->
        <form method="POST" action="/tasks" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="title" 
                class="border p-2 flex-1 rounded focus:ring-2 focus:ring-blue-500 outline-none" 
                placeholder="New Task" required>
            
            <!-- VISIBLE ADD BUTTON -->
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold shadow-sm transition">
                Add Task
            </button>
        </form>

        <!-- Task List -->
        @foreach($tasks as $task)
            <div class="flex items-center justify-between mb-2 p-2 border rounded hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <form method="POST" action="/tasks/{{ $task->id }}">
                        @csrf
                        @method('PATCH')
                        <button class="mr-2">
                            {{ $task->is_done ? '✅' : '⬜' }}
                        </button>
                    </form>

                    <span class="{{ $task->is_done ? 'line-through text-gray-400' : 'text-gray-800' }}">
                        {{ $task->title }}
                    </span>
                </div>

                <form method="POST" action="/tasks/{{ $task->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4 font-medium">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach

        @if($tasks->isEmpty())
            <p class="text-center text-gray-500 mt-4">No tasks found. Add one above!</p>
        @endif
    </div>
</body>
</html>