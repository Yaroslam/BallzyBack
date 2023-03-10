<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>
        @if(!Auth::guest())
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Уведомления <span class="badge bg-info text-dark">
                                            {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <li><a class="dropdown-item" href="#">{{ $notification->data['thing']['name'] }}</a></li>
                                @endforeach
{{--                <li><a class="dropdown-item" href="#">1</a></li>--}}
{{--                <li><a class="dropdown-item" href="#">1</a></li>--}}
{{--                <li><a class="dropdown-item" href="#">1</a></li>--}}
{{--                <li><a class="dropdown-item" href="#">1</a></li>--}}
            </ul>
        </li>
        @endif
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link @linkactive('/')">Home</a></li>
          <li><a href="{{ route("Shoes.create") }}" class="nav-link">Parse</a></li>
          <li><a href="{{ route("addToMarket") }}" class="nav-link">Upload</a></li>
          <li><a href="{{ route("cleanMarket") }}" class="nav-link">Clean</a></li>
          <li><a href="{{ route("createAlbums") }}" class="nav-link">Create Albums</a></li>
      </ul>

      @auth
        {{auth()->user()->name}}
{{--        <div class="text-end">--}}
{{--          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>--}}
{{--        </div>--}}
      @endauth
      @guest
{{--        <div class="text-end">--}}
{{--          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>--}}
{{--          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>--}}
{{--        </div>--}}
      @endguest
    </div>
  </div>
    <script src="{{ asset('js/app.js') }}"></script>
</header>
