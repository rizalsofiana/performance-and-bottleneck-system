@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')

  <div class="w-full max-w-sm">

    {{-- Logo & judul --}}
    <div class="mb-8 text-center">
      <div class="mx-auto flex size-12 items-center justify-center rounded-xl bg-brand text-white shadow-sm shadow-blue-900/20">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6" aria-hidden="true">
          <rect width="8" height="8" x="3" y="3" rx="2"/><path d="M7 11v4a2 2 0 0 0 2 2h4"/><rect width="8" height="8" x="13" y="13" rx="2"/>
        </svg>
      </div>
      <h1 class="mt-4 text-2xl font-semibold tracking-tight text-slate-900">SmartHRIS</h1>
      <p class="mt-1 text-sm text-slate-500">Masuk untuk melanjutkan ke portal Anda</p>
    </div>

    {{-- Kartu form --}}
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">

      @if ($errors->any())
        <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
          <input id="email" name="email" type="email" required autofocus autocomplete="username"
                 value="{{ old('email') }}"
                 placeholder="nama@utb.ac.id"
                 class="mt-1.5 block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-blue-100" />
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-slate-700">Kata Sandi</label>
            <a href="#" class="text-sm font-medium text-brand hover:text-brand-dark">Lupa kata sandi?</a>
          </div>
          <input id="password" name="password" type="password" required autocomplete="current-password"
                 placeholder="••••••••"
                 class="mt-1.5 block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand focus:outline-none focus:ring-2 focus:ring-blue-100" />
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
          <input type="checkbox" name="remember" class="size-4 rounded border-slate-300 text-brand focus:ring-brand" />
          Ingat saya
        </label>

        <button type="submit"
                class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand">
          Masuk
        </button>
      </form>
    </div>

    <p class="mt-6 text-center text-xs text-slate-400">&copy; {{ date('Y') }} SmartHRIS. Seluruh hak cipta dilindungi.</p>
  </div>

@endsection
