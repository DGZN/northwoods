@extends('auth.layouts.master-no-nav')

@section('title', 'North Woods Admin Dashboard')

@section('content')
  <div class="container">
      <form method="POST" action="/auth/register">
          {!! csrf_field() !!}

          <div>
              Name
              <input type="text" name="name" value="{{ old('name') }}">
          </div>

          <div>
              Email
              <input type="email" name="email" value="{{ old('email') }}">
          </div>

          <div>
              Password
              <input type="password" name="password">
          </div>

          <div>
              Confirm Password
              <input type="password" name="password_confirmation">
          </div>

          <div>
              <button type="submit">Register</button>
          </div>
      </form>
  </div>
@endsection

@section('scripts')
<script style="text/javascript">

</script>
@endsection
