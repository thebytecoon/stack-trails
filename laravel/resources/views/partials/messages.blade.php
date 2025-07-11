@if (session()->has('error'))
    <div class="p-4 mb-4 rounded-lg text-center bg-red-50 dark:bg-gray-800 dark:text-red-400 text-red-800 border-red-300 dark:border-red-800" role="alert">
        <div>
            {{ session('error') }}
        </div>
    </div>
@endif

@if (session()->has('success'))
    <div class="p-4 mb-4 rounded-lg text-center  text-green-800 border border-green-300 bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <div>
            {{ session('success') }}
        </div>
    </div>
@endif