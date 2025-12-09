@extends('layouts.app')

@section('content')
    <div class="  bg-gray-100 text-gray-900 flex justify-center items-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">

            <!-- Gambar di Kiri (Agar variatif, posisi gambar bisa ditukar jika mau) -->
            <div class="flex items-center justify-center sm:hidden md:flex lg:flex xl:flex 2xl:flex hidden lg:flex">

                <img src="{{ asset('assets/emisi.png') }}" alt="" class="w-3xl h-auto  ">
            </div>

            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <div>
                    <img src="https://drive.google.com/uc?export=view&id=1MFiKAExRFF0-2YNpAZzIu1Sh52J8r16v"
                        class="w-32 mx-auto" />
                </div>
                <div class="mt-12 flex flex-col items-center">
                    <h1 class="text-2xl xl:text-3xl font-extrabold">
                        Sign Up
                    </h1>

                    <div class="w-full flex-1 mt-8">
                        <div class="my-5 border-b text-center">
                            <div
                                class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                                Create new account
                            </div>
                        </div>

                        <!-- Form Register Laravel -->
                        <form action="{{ route('register.submit') }}" method="POST" class="mx-auto max-w-xs">
                            @csrf

                            <!-- Input Nama -->
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border @error('name') border-red-500 @else border-gray-200 @enderror placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required
                                autofocus />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror

                            <!-- Input Email -->
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border @error('email') border-red-500 @else border-gray-200 @enderror placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror

                            <!-- Input Password -->
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border @error('password') border-red-500 @else border-gray-200 @enderror placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                type="password" name="password" placeholder="Password (Min. 6 chars)" required />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror

                            <!-- Input Confirm Password -->
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                type="password" name="password_confirmation" placeholder="Confirm Password" required />

                            <!-- Tombol Submit -->
                            <button type="submit"
                                class="mt-5 tracking-wide font-semibold bg-green-400 text-white w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <path d="M20 8v6M23 11h-6" />
                                </svg>
                                <span class="ml-2">
                                    Register
                                </span>
                            </button>

                            <!-- Link ke Login -->
                            <p class="mt-6 text-sm text-gray-600 text-center">
                                Already have an account?
                                <a href="{{ route('login') }}"
                                    class="border-b border-gray-500 border-dotted font-bold text-green-600">
                                    Sign In
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection