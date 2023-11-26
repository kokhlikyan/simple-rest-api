@extends('layouts.base')
@php
    $token = request('token');
    $email = request('email');
@endphp
@section('content')
    <div class="row justify-content-center py-5">
        <div class="col-4">
            <h1>Reset password</h1>
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first()}}
                </div>
            @endif
            <form action="{{route('password.change')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="hidden" name="token" value="{{$token}}">
                    <input type="hidden" name="email" value="{{$email}}">
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="********" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                           placeholder="********" required>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
