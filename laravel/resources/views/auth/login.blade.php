@extends('master')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-sm p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In to TechStore</h2>
        <form class="space-y-4" method="post" action="{{ route('login') }}">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">email</label>
                <input id="email" name="email" type="email" required placeholder="you@example.com"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-revolut-blue">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required placeholder="••••••••"
                    class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-revolut-blue">

            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox"
                        class="h-4 w-4 text-revolut-blue focus:ring-revolut-blue border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Remember me</span>
                </label>
                <a href="#" class="text-sm text-revolut-blue hover:underline">Forgot your password?</a>
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-revolut-blue text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">Sign
                    In</button>
            </div>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            Don't have an account? <a href="#" class="text-revolut-blue hover:underline">Sign up</a>
        </p>
    </div>
</div>
@endsection
