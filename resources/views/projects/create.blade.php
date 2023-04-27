@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Project CREATE</h3>
    <div class="container">
        <h1>Nuovo Project</h1>
    </div>
    <div class="container">
        <form action="{{ route('projects.store') }}" method="POST">

            @csrf

            <div class="mb-3">
              <label for="title" class="form-label">Titolo</label>
              <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" id="title" aria-describedby="titleHelp">

              <label for="client" class="form-label">Cliente</label>
              <input type="text" name="client" class="form-control @error('client') is-invalid @enderror" value="{{ old('client') }}" id="client" aria-describedby="clientHelp">




                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @error('client')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror



            </div>


            {{-- select delle categorie --}}
            <div class="mb-3">
                <label for="categories">Categorie</label>
              <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category-id">
                <option value="" selected>seleziona categoria</option>
                @foreach ($categories as $category)
                    <option @selected( old('category_id') === $category->id ) value="{{$category->id}}">
                        {{$category->name}}
                    </option>
                @endforeach

              </select>


              @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="mb-3">
              <label for="description" class="form-label">Descrizione</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button type="submit" class="btn btn-primary">Crea</button>
          </form>
    </div>

</div>
@endsection
