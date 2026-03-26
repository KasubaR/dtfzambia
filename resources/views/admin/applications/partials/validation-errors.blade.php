@if ($errors->any())
  <div class="app-validation-errors" role="alert">
    <strong class="app-validation-errors-title">Could not save</strong>
    <ul class="app-validation-errors-list">
      @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
      @endforeach
    </ul>
  </div>
@endif
