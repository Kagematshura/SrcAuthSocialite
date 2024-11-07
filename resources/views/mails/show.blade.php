@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900">{{ $mail->name }}</h1>

    <p class="text-gray-700 mb-4"><strong>Email :</strong> {{ $mail->email }}</p>
    <p class="text-gray-700 mb-4"><strong>Telp Number :</strong> {{ $mail->phone }}</p>
    <p class="text-gray-700 mb-4"><strong>Sent at :</strong> {{ $mail->created_at->format('M d, Y') }}</p>

    <div class="prose">
        {!! $mail->message !!}
    </div>
</div>
@endsection
