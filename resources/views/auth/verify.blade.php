@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Оновлений посилання для підтвердження було надіслано на вашу email адресу.') }}
                        </div>
                    @endif

                    {{ __('Перед тим як продовжити, будь ласка, перевірте вашу email адресу на наявність посилання для підтвердження.') }}
                    {{ __('Якщо ви не отримали email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('клацніть тут, щоб запросити інший') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
