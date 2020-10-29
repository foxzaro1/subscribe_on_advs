@extends('include.app')
@section('title')
    Confirm  Email
@endsection
@section('content')
    <div class="login-page">
        <div class="form">
            <form class="verify-form" action="{{route('verify-form')}}" method="post">
                @csrf
                <input type="text" name="code" id="code" value="{{$id}}" placeholder="verify code"/>
                <button>Send</button>
            </form>
        </div>
    </div>
@endsection
