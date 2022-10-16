@extends('admin.layouts.layout')

@section('admincontent')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4>Subcategorie bewerken</h4>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            {{-- form> --}}
            <form role="form" method="post" action="{{ route('admin.subcategories.update', $subcategory->slug) }}">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Subcategorie  {{ $subcategory->name }}</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid" @enderror id="name" value="{{ $subcategory->name }}">
                </div>
                <div class="form-group">
                  <label for="category_id">Categorie slug {{ $subcategory->category_slug }}</label>
                  <input type="text" name="category_slug" class="form-control @error('category_slug') is-invalid" @enderror id="category_slug" value="{{ $subcategory->category_slug }}">
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection