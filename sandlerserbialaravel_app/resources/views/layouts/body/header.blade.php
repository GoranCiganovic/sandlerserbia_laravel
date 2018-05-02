<li class="dropdown main-head-nav">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      <span class="text-primary">
        <span class="global-training-logo-sm glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Global Training<span class="caret"></span>
      </span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
          <a href="{{ url('/global_training/edit') }}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Profil GT</a>
        </li>
        <li>
          <a href="{{ url('/taxes/edit') }}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Porez</a>
        </li>
        <li>
          <a href="{{ url('/sandler/edit') }}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Sandler</a>
        </li>
        <li>
          <a href="{{ url('/disc_devine/edit') }}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Disc/Devine</a>
        </li>
        <li>
          <a href="{{ url('/exchange') }}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Kurs</a>
        </li>
        <li>
          <a href="{{ url('articles') }}"><i class="fa fa-btn fa-pencil-square-o" aria-hidden="true"></i>Šablon Ugovora</a>
        </li>
    </ul>
</li>
<li class="dropdown main-head-nav">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      <span class="text-primary">
        <i class="fa fa-institution" aria-hidden="true"></i>&nbsp;Sandler Systems<span class="caret"></span>
      </span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
          <a href="http://www.sandler.com/" target="_blank"><span class="sandler-systems-icon glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Global Sandler</a>
        </li>
        <li>
          <a href="http://www.serbia.sandler.com/" target="_blank"><span class="hraniti-ego glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Serbia Sandler</a>
        </li>
    </ul>
</li>
<li class="dropdown main-head-nav">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      <span class="text-primary">
        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{ Auth::user()->name }} <span class="caret"></span>
      </span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
          <a href="/user/edit/{{ Auth::user()->id }} "><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;Moj profil</a>
        </li>
        @if(Auth::user()->is_admin == '1')
        <li>
          <a href="{{ url('/users') }}"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Korisnici</a>
        </li>
        @endif
        <li>
          <a href="{{ url('/logout') }}" id="logout_confirm" ><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Odjavi se</a>
        </li>
    </ul>
</li>



     



