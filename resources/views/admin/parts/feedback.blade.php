@if(session('errors'))
    <div class="alert alert-danger alert-dismissible fade show">
      <strong>Perhatian!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <strong>Sukses!</strong>
      {{ Session::get('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <strong>Peringatan!</strong>
      {{ Session::get('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
    </div>
@endif