<div class="parallax-container gym-parallax">
    <div class="row entete-info container">
        <div class="square-entete">
            <img src="{{ $logo }}" alt="">
        </div>
        <div class="liste-info">
            <h1 class="loved-king-font"><span>salle d'escalade </span>{{$label}}</h1>
            <p>{{$city}}, {{$region}} ({{$code_country}})</p>
            @if(Auth::check())
                <p onclick="followedElement(this, 'Gym', {{$gym->id}})" class="follow-paragraphe" data-followed="{{$user_follow}}">
                    <span id="followed-element"><i class="material-icons amber-text">star</i> Ne plus suivre cette salle</span>
                    <span id="not-followed-element"><i class="material-icons with-text">star_border</i> Suivre cette salle</span>
                </p>
            @else
                <p>Connectez-vous pour suivre cette salle</p>
            @endif
        </div>
    </div>
    <div class="parallax">
        <img class="img-gym-parallax" src="{{$imgSrc}}" alt="{{$imgAlt}}">
    </div>
</div>