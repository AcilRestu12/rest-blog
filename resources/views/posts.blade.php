{{-- Mengextends halaman main.blade.php --}}
@extends('layouts.main')

{{-- Mengisi halaman parent untuk section container --}}
@section('container')     

    {{-- Heading --}}
    <div class="contaier">
        {{-- Heading --}}
        <h1 class="h1 mt-5" style="font-family: 'Vollkorn';
        font-style: normal;
        font-weight: 400;
        font-size: 5em;
        line-height: 111px;
        text-shadow: 1px 2px 2px rgba(0,0,0,0.15);
        color: #000000;">
            Blog
        </h1>
        
        {{-- Search Bar --}}
        <div class="row mt-4 mb-5">
            <div class="col-md-8">
                {{-- Data dari form-nya akan dikirim ke url di halaman posts --}}
                <form action="/posts" method="get">
                    {{-- Apabila telah memilih suatu category --}}
                    @if (request('category'))
                        {{-- Melakukan input category --}}
                        <input type="hidden" name='category' value="{{ request('category') }}">
                    @endif
                    {{-- Apabila telah memilih suatu author --}}
                    @if (request('author'))
                        {{-- Melakukan input author --}}
                        <input type="hidden" name='author' value="{{ request('author') }}">
                    @endif
                    <div class="input-group mb-3">
                        {{-- Melakukan input search --}}
                        <label class="input-group-text" for="searchBar"><span data-feather="search" ></span></label>
                        <input type="text" class="form-control" placeholder="Search..." name="search"  value="{{ request('search') }}" id="searchBar">
                        <button class="btn btn-secondary" type="submit" >Button</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Mengecek apakah ada posts atau tidak --}}
    @if ( $posts->count() )
        {{-- Lastest Post --}}
        <div class="container">
            {{-- Sub Heading Lastest Post --}}
            <div class="row my-5 border-top border-bottom border-4 py-2 d-flex align-items-center">
                <div class="col-auto me-auto">
                    <p class="h1 text-uppercase" style="font-family: 'Montserrat';
                    font-style: normal;
                    font-weight: 600;
                    font-size: 2.5em;
                    line-height: 49px;
                    letter-spacing: -0.015em;
                    text-shadow: 1px 2px 2px rgba(0,0,0,0.15);
                    color: #202020;">
                        The lastest articles
                    </p>
                </div>
                <div class="col-auto">
                    {{-- Link view all posts --}}
                    <a class="link-secondary" href="" style="font-family: 'Montserrat';
                    font-style: normal;
                    font-weight: 300;
                    font-size: 1em;
                    line-height: 17px;
                    letter-spacing: -0.015em;                
                    color: #7A7B7A;">
                        View all
                    </a>
                </div>
            </div>

            {{-- Lastest Post --}}
            <div class="row mb-5">
                @for ($i = 0; $i < 3; $i++)
                    <div class="col-md-4">
                        {{-- Apabila ada gambar di table post --}}
                        @if ( $posts[$i]->image )
                            <div style="max-height: 400px; overflow:hidden;">
                                {{-- Mengambil gambar dari storage sesuai dengan nama file gambar di table post --}}
                                <img src="{{ asset('storage/' . $posts[$i]->image) }}" alt="{{ $posts[$i]->category->name }}" class="img-fluid rounded-1"  width="720" style="box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.5);">
                            </div>
                        @else
                            {{-- Menampilkan gambar random dari unsplash --}}
                            <img src="https://source.unsplash.com/1200x720?{{ $posts[$i]->category->name }}" class="img-fluid rounded-1" alt="{{ $posts[$i]->category->name }}" width="720" style="box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.5);">
                        @endif
                        
                        {{-- Info Post --}}
                        <p class="text-muted d-flex justify-content-between mb-1 mt-1" style="font-family: 'Montserrat';
                        font-style: normal;
                        font-weight: 300;
                        font-size: .75em;
                        color: #546463;"> 
                            <span>{{ $posts[$i]->created_at->diffForHumans() }}</span>
                            <span class="text-uppercase">
                                —By <a href="/posts?author={{ $posts[$i]->author->username }}" class="text-decoration-none">{{ $posts[$i]->author->name }}</a>
                            </span>
                        </p>
                        
                        {{-- Title Post --}}
                        <h3 class="h3 mt-3 mb-4" style="font-family: 'Vollkorn', serif;
                        font-style: normal;
                        font-weight: 500;
                        font-size: 1.5em;
                        letter-spacing: -0.015em;
                        color: #303030;">
                            <a href="/posts/{{ $posts[$i]->slug }}" class="text-decoration-none text-dark">{{ $posts[$i]->title }}</a>
                        </h3>
                    </div>
                @endfor
            </div>
        </div>  

        {{-- Posts --}}
        <div class="container">
            {{-- Categories --}}
            <div class="row my-5">
                <ul class="nav justify-content-center align-items-center border-top border-bottom border-4 py-2 text-capitalize" style="font-family: 'Montserrat';
                font-style: normal;
                font-weight: 600;
                font-size: 1.25em;
                line-height: 24px;
                letter-spacing: -0.015em;
                ">
                    <li class="nav-item px-3">
                        <a class="nav-link active link-dark text-decoration-underline" href="/posts">view all</a>
                    </li>
                    {{-- Melakukan looping untuk setiap category yg diterima dari route web --}}
                    @foreach ($categories as $category)
                        <li class="nav-item px-3">
                            <a class="nav-link link-secondary" href="/posts?category={{ $category->slug }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Menskip data post pertama --}}
            @foreach ($posts->skip(3) as $post)
                {{-- Post --}}
                <div class="row my-5">
                    {{-- Image Post --}}
                    <div class="col-md-4 me-2">
                        {{-- Apabila ada gambar di table post --}}
                        @if ( $post->image )
                            {{-- Mengambil gambar dari storage sesuai dengan nama file gambar di table post --}}
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid rounded-1" width="720" style="box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.5);">
                        @else
                            {{-- Menampilkan gambar random dari unsplash --}}
                            <img src="https://source.unsplash.com/1200x720?{{ $post->category->name }}" class="img-fluid rounded-1" alt="{{ $post->category->name }}" width="720" style="box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.5);">
                        @endif
                    </div>
                    {{-- Detail Post --}}
                    <div class="col-md">
                        <p class="text-uppercase text-muted my-1" style="font-family: 'Montserrat';
                        font-style: normal;
                        font-weight: 300;
                        font-size: 1em;
                        line-height: 10px;
                        color: #546463;">
                            —By {{ $post->author->name }}
                        </p>
                        
                        <p class="h2 mt-4" style="font-family: 'Vollkorn', serif;
                        font-style: normal;
                        font-weight: 500;
                        font-size: 2.5em;
                        line-height: 56px;
                        letter-spacing: -0.015em;
                        color: #303030;">
                            {{ $post->title }}
                        </p>
                        
                        <p class="mb-2" style="font-family: 'Cantarell', sans-serif;
                        font-style: normal;
                        font-weight: 500;
                        font-size: 1.2em;
                        line-height: 23px;
                        letter-spacing: -0.015em;
                        color: #666666;">
                            {{ $post->excerpt }}
                        </p>

                        {{-- Link untuk menuju single post dari suatu post tertentu --}}
                        <a href="/posts/{{ $post->slug }}" class="text-decoration-none" class="btn btn-primary">Read more</a>

                        <p class="text-muted mt-4" style="font-family: 'Montserrat';
                        font-style: normal;
                        font-weight: 300;
                        font-size: 1em;
                        line-height: 10px;
                        color: #546463;">
                            tgl • {{ $posts[$i]->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
            

            {{-- Post 2 --}}
            <div class="row my-5">
                <div class="col-md-4 me-2">
                    <img src="https://source.unsplash.com/1200x500" class="img-fluid" alt="...">
                </div>
                <div class="col-md">
                    <p class="text-uppercase text-muted my-1" style="font-family: 'Montserrat';
                    font-style: normal;
                    font-weight: 300;
                    font-size: 1em;
                    line-height: 10px;
                    color: #546463;">
                        —By User
                    </p>
                    
                    <p class="h2 mt-4" style="font-family: 'Vollkorn', serif;
                    font-style: normal;
                    font-weight: 500;
                    font-size: 2.5em;
                    line-height: 56px;
                    letter-spacing: -0.015em;
                    color: #303030;">
                        Judul
                    </p>
                    
                    <p class="mb-2" style="font-family: 'Cantarell', sans-serif;
                    font-style: normal;
                    font-weight: 500;
                    font-size: 1.2em;
                    line-height: 23px;
                    letter-spacing: -0.015em;
                    color: #666666;">
                        excerpt
                    </p>

                    <p class="text-muted mt-4" style="font-family: 'Montserrat';
                    font-style: normal;
                    font-weight: 300;
                    font-size: 1em;
                    line-height: 10px;
                    color: #546463;">
                        tgl • time 
                    </p>
                </div>
            </div>

            {{-- Show More --}}
            <div class="row my-5 mx-1">
                <button type="button" class="btn btn-outline-dark p-2">Show more</button>
            </div>
        </div>

    {{-- Apabila post-nya tidak ada --}}
    @else
        <p class="text-center fs-4">No post found.</p>
    @endif
    




    
    
    {{-- Menerima data dari yg dikirim dari PostController.php --}}
    <h1 class="mb-3 text-center">{{ $title }}</h1>
    
    {{-- Search Bar --}}
    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            {{-- Data dari form-nya akan dikirim ke url di halaman posts --}}
            <form action="/posts" method="get">
                {{-- Apabila telah memilih suatu category --}}
                @if (request('category'))
                    {{-- Melakukan input category --}}
                    <input type="hidden" name='category' value="{{ request('category') }}">
                @endif
                {{-- Apabila telah memilih suatu author --}}
                @if (request('author'))
                    {{-- Melakukan input author --}}
                    <input type="hidden" name='author' value="{{ request('author') }}">
                @endif
                <div class="input-group mb-3">
                    {{-- Melakukan input search --}}
                    <input type="text" class="form-control" placeholder="Search.." name="search"  value="{{ request('search') }}">
                    <button class="btn btn-danger" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>



    {{-- Mengecek apakah ada posts atau tidak --}}
    @if  ( $posts->count() )

    
    
        {{-- Hero Card Post --}}
        <div class="card mb-3 text-center">
            {{-- Apabila ada gambar di table post --}}
            @if ( $posts[0]->image )
                <div style="max-height: 400px; overflow:hidden;">
                    {{-- Mengambil gambar dari storage sesuai dengan nama file gambar di table post --}}
                    <img src="{{ asset('storage/' . $posts[0]->image) }}" alt="{{ $posts[0]->category->name }}" class="img-fluid">
                </div>
            @else
                {{-- Menampilkan gambar random dari unsplash --}}
                <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">
            @endif
            <div class="card-body">
            <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
            <p>
                <small class="text-muted">
                    By. <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $posts[0]->author->name }}</a> in <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none">{{ $posts[0]->category->name }}</a> {{ $posts[0]->created_at->diffForHumans() }}
                </small>
            </p>
            <p class="card-text">{{ $posts[0]->excerpt }}</p>
            <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read more<a>     
            </div>
        </div>
    
        {{-- Card Posts --}}
        <div class="container">
            {{-- Melakukan looping untuk setiap posts yg ada --}}
            <div class="row">
                {{-- Menskip data post pertama --}}
                @foreach ($posts->skip(1) as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            {{-- Menampilkan kategori dari post yg ditampilkan --}}
                            <div class="position-absolute px-3 py-2 text-white" style="background-color: rgba(0, 0, 0, .7)">
                                <a href="/posts?category={{ $post->category->slug }}" class="text-white text-decoration-none">{{ $post->category->name }}</a>
                            </div>
                            
                            {{-- Apabila ada gambar di table post --}}
                            @if ( $post->image )
                                {{-- Mengambil gambar dari storage sesuai dengan nama file gambar di table post --}}
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">
                            @else
                                {{-- Menampilkan gambar random dari unsplash --}}
                                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}">
                            @endif
                            
                            <div class="card-body">
                                {{-- Mengirim slug dari suatu post melalui url --}}
                                <h5 class="card-title">{{ $post->title }}</h5>

                                {{-- Menampilkan author / user post yg ditampilkan --}}
                                <p>By. <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a></p>

                                {{-- Menampilkan excerpt dari post yg ditampilkan --}}
                                <p class="card-text">{{ $post->excerpt }}</p>

                                {{-- Link untuk menuju single post dari suatu post tertentu --}}
                                <a href="/posts/{{ $post->slug }}" class="text-decoration-none" class="btn btn-primary">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    {{-- Apabila post-nya tidak ada --}}
    @else
        <p class="text-center fs-4">No post found.</p>
    @endif

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{-- Menampilkan halaman pagination --}}
        {{ $posts->links() }}
    </div>

    @include('partials.footer')

@endsection
