@extends('layouts.app', [
    'meta_title'=> trans('meta/project.title_developer'),
    'meta_description'=>trans('meta/project.description_developer'),
    'meta_img'=>'https://oblyk.org/img/meta_home.jpg',
    ])

@section('content')

    {{--parallax--}}
    @include('includes.parallax', array('imgSrc' => '/img/oblyk-home-baume-rousse.jpg', 'imgAlt' => 'Falaise de baume rousse'))

    {{--contenu de la page--}}
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h1 class="loved-king-font text-center grey-text text-darken-3">@lang('pages/projects/developer.title')</h1>

                <p class="text-center grey-text">Coming soon</p>

            </div>
        </div>
    </div>

@endsection
