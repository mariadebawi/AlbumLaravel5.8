@extends('layouts.app')
@section('content')

    <div class="site-wrapper">
        <div class="site-wrapper-inner text-white text-center">
            <i class="fas fa-spinner fa-pulse fa-4x"></i>
        </div>
    </div>

    <main class="container-fluid">
        @isset($category)
            <h2 class="text-title mb-3">{{ $category->name }}</h2>
        @endif
        @isset($user)
            <h2 class="text-title mb-3">{{ __('Photos de ') . $user->name }}</h2>
        @endif
        <div class="d-flex justify-content-center">
            {{ $images->links() }}
        </div>
        <div class="card-columns">
            @foreach($images as $image)
                <div class="card @if($image->adult) border-danger @endif" id="image{{ $image->id }}">
                    <a href="{{ url('images/' . $image->name) }}" class="image-link">
                        <img class="card-img-top"
                             src="{{ url('thumbs/' . $image->name) }}"
                             alt="image">
                    </a>
                    @isset($image->description)
                        <div class="card-body">
                            <p class="card-text">{{ $image->description }}</p>
                        </div>
                    @endisset
                    <div class="card-footer text-muted">
                        <em>
                            <a href="{{ route('user', $image->user->id) }}" data-toggle="tooltip"
                               title="{{ __('Voir les photos de ') . $image->user->name }}">{{ $image->user->name }}</a>
                        </em>
                        <div class="float-right">
                            <em>
                                {{ $image->created_at->formatLocalized('%x') }}
                            </em>
                            <div>
                                <div class="star-rating" id="{{ $image->id }}">
                                      <span class="float-right">

            <a class="toggleIcons"
               href="#">
            <i class="fa fa-cog"></i>
            </a>
            <span class="menuIcons" style="display: none">
                <a class="form-delete text-danger"
                   href="{{ route('image.destroy', $image->id) }}"
                   data-toggle="tooltip"
                   title="@lang('Supprimer cette photo')">
                    <i class="fa fa-trash"></i>
                </a>
                <a class="description-manage"
                   href="#"
                   data-toggle="tooltip"
                   title="@lang('Gérer la description')">
                    <i class="fa fa-comment"></i>
                </a>
                <a class="category-edit"
                   data-id="{{ $image->category_id }}"
                   href="{{ route('image.update', $image->id) }}"
                   data-toggle="tooltip"
                   title="@lang('Changer de catégorie')">
                    <i class="fa fa-edit"></i>
                </a>
                <a class="adult-edit"
                   href="#"
                   data-toggle="tooltip"
                   title="@lang('Changer de statut')">
                    <i class="fa @if($image->adult) fa-graduation-cap @else fa-child @endif"></i>
                </a>
            </span>
            <form action="{{ route('image.destroy', $image->id) }}" method="POST" class="hide">
                @csrf
                @method('DELETE')
            </form>
    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $images->links() }}
        </div>
    </main>
@endsection
@section('script')
    <script>
        $(() => {
            $('.site-wrapper').fadeOut(1000)

            $('[data-toggle="tooltip"]').tooltip()
            $('.card-columns').magnificPopup({
                delegate: 'a.image-link',
                type: 'image',
                tClose: '@lang("Fermer (Esc)")'@if($images->count() > 1),
                gallery: {
                    enabled: true,
                    tPrev: '@lang("Précédent (Flèche gauche)")',
                    tNext: '@lang("Suivant (Flèche droite)")'
                },
                callbacks: {
                    buildControls: function () {
                        this.contentContainer.append(this.arrowLeft.add(this.arrowRight))
                    }
                }@endif
        })
            $('a.toggleIcons').click((e) => {
                e.preventDefault();
                let that = $(e.currentTarget)
                that.next().toggle('slow').end().children().toggleClass('fa-cog').toggleClass('fa-play')
            });


            $('a.form-delete').click((e) => {
                e.preventDefault();
                let href = $(e.currentTarget).attr('href')
                swal.fire({
                    title: '@lang('Vraiment supprimer cette photo ?')',
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '@lang('Oui')',
                    cancelButtonText: '@lang('Non')'
                }).then((result) => {
                    if (result.value) {
                        $("form[action='" + href + "'").submit()
                    }
                })
            })
        })
    </script>
@endsection
