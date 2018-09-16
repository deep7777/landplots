@if (count($errors) > 0)
  <br />
  <div class="alert alert-danger text-center">
    <div>
      @foreach ($errors->all() as $error)
        <div class="">{{ $error }}</div>
      @endforeach
    </div>
  </div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <strong>{{ $message }}</strong>
</div>
<br />
@endif
