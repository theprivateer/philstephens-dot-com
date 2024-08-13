<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ config('app.name') }}</title>

        @include('feed::links')
        @vite(['resources/scss/site.scss'])
    </head>
    <body>
        <main class="container">
            <section class="masthead">
                <a href="/" class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="32" fill="currentColor" viewBox="0 0 233 320" >
                        <g transform="matrix(1,0,0,1,-1.0608,-1.85537)">
                            <g transform="matrix(4.16667,0,0,4.16667,-148.94,-3122.08)">
                                <path d="M88.606,783.783C89.039,781.334 91.318,765.257 77.789,759.682C77.789,759.681 77.79,759.68 77.79,759.679C77.973,757.36 77.169,756.309 77.169,756.309C76.293,758.498 73.915,758.484 73.915,758.484C74.599,753.22 71.917,749.745 71.917,749.745C70.167,757.622 60.102,757.622 60.134,757.78L60.132,757.794C35.567,758.343 38.737,780.848 39.256,783.783C38.367,783.529 35.667,783.197 36.034,788.692C36.463,795.132 37.316,802.829 41.479,802.706L41.504,802.915C42.598,825.451 63.384,826.545 63.384,826.545L64.697,826.545L64.697,826.529C66.911,826.336 85.33,824.095 86.358,802.915L86.383,802.706C90.546,802.829 91.399,795.132 91.829,788.692C92.195,783.197 89.495,783.529 88.606,783.783M64.649,788.056L60.702,779.088L48.505,784.11L63.214,767.25L67.16,775.859L79.357,771.196L64.649,788.056Z" style="fill-rule:nonzero;"/>
                            </g>
                        </g>
                    </svg>
                </a>

                <nav>
                    <ul>
                        <li><a href="{{ route('posts') }}">Posts</a></li>
                        <li><a href="{{ route('notes') }}">Notes</a></li>
                        <li><a href="{{ route('links') }}">Links</a></li>
                    </ul>
                </nav>
            </section>

            @yield('content')

            <section class="footer">
                <div>
                    <h5>Sitemap</h5>

                    <ul>
                        <li><a href="{{ route('posts') }}">Posts</a></li>
                        <li><a href="{{ route('notes') }}">Notes</a></li>
                        <li><a href="{{ route('links') }}">Links</a></li>
                        <li><a href="{{ route('albums') }}">365 Albums Project</a></li>
                    </ul>
                </div>

                <div>
                    <h5>Connect</h5>

                    <ul>
                        {{-- <li><a href="https://www.linkedin.com/in/phil-stephens/" target="_blank">LinkedIn</a></li> --}}
                        {{-- <li><a href="https://github.com/theprivateer" target="_blank">Github</a></li> --}}
                        <li><a href="mailto:hello@philstephens.com">Email</a></li>
                    </ul>
                </div>

                <p>&copy; {{ date('Y') }} Phil Stephens</p>
                {{-- <ul>
                    <li>RSS:</li>
                    <li><a href="/feed">Blog</a></li>
                    <li><a href="/albums/feed">Albums</a></li>
                </ul> --}}
            </section>
        </main>

        @if(config('app.env') === 'production' && config('services.tinylytics.id'))
        <script src="https://tinylytics.app/embed/{{ config('services.tinylytics.id') }}.js" defer></script>
        @endif
    </body>
</html>
