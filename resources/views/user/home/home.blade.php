@extends('user.layout.blank')

@section('content')

<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

<div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center gy-5">
    <div class="col-lg-7">
        <div class="hero-card shadow-sm" data-aos="fade-right" data-aos-delay="150">
        <div class="eyebrow d-inline-flex align-items-center mb-3">
            <i class="bi bi-stars me-2"></i>
            <span>Lorem ipsum vivamus dictum</span>
        </div>
        <div class="content">
            <h2 class="display-5 fw-bold mb-3">Build modern interfaces that feel effortless</h2>
            <p class="lead mb-4">Nibh tristique gravida arcu, posuere luctus imperdiet. Aenean varius sem id, at ullamcorper sodales lectus purus facilisis.</p>
            <div class="d-flex flex-wrap gap-3">
            <a href="#about" class="btn btn-primary-ghost">
                <span>Explore Now</span>
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-video d-inline-flex align-items-center">
                <span class="play-icon d-inline-flex align-items-center justify-content-center me-2">
                <i class="bi bi-play-fill"></i>
                </span>
                <span>Watch Overview</span>
            </a>
            </div>
            <div class="mini-stats d-flex flex-wrap gap-4 mt-4" data-aos="zoom-in" data-aos-delay="250">
            <div class="stat d-flex align-items-center">
                <i class="bi bi-lightning-charge me-2"></i>
                <span>Fusce aptent interdum</span>
            </div>
            <div class="stat d-flex align-items-center">
                <i class="bi bi-shield-check me-2"></i>
                <span>Quam nunc tempor</span>
            </div>
            <div class="stat d-flex align-items-center">
                <i class="bi bi-people me-2"></i>
                <span>Ultricies porta lectus</span>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="media-stack" data-aos="zoom-in" data-aos-delay="200">
        <figure class="media primary shadow-sm">
            <img src="assets/img/illustration/illustration-8.webp" class="img-fluid" alt="Hero visual">
        </figure>
        <figure class="media secondary shadow-sm">
            <img src="assets/img/illustration/illustration-15.webp" class="img-fluid" alt="Supporting visual">
        </figure>
        <div class="floating-badge d-flex align-items-center shadow-sm" data-aos="fade-down" data-aos-delay="300">
            <i class="bi bi-award me-2"></i>
            <span>Curabitur congue pretium</span>
        </div>
        </div>
    </div>
    </div>

</div>

</section><!-- /Hero Section -->
<!-- CARD Section -->
<section id="team" class="team section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>CARD</h2>
        <p>CARD RẺ CARD RÊ MẠI DÔ MẠI DÔ</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <!-- Large modal -->
        <button id="upload-1" type="button" class="btn btn-primary" >Upload 1</button>
        <button id="upload-2" type="button" class="btn btn-primary" >Upload 2</button>

        

        <div class="row g-4 align-items-stretch">

        <div class="col-md-6 col-lg-3">
            <article class="member-card h-100" data-aos="zoom-in" data-aos-delay="150">
            <figure class="member-media">
                <img src="assets/img/person/person-f-9.webp" class="img-fluid" alt="Team member portrait">
                <ul class="social-list">
                <li><a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a></li>
                <li><a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="#" aria-label="Github"><i class="bi bi-github"></i></a></li>
                </ul>
            </figure>
            <div class="member-content">
                <h3 class="member-name">Ava Thompson</h3>
                <p class="member-role">Product Strategist</p>
                <p class="member-bio">Consequatur illum numquam doloremque, sed vitae ipsa dolores. Aspernatur dicta facilis incidunt.</p>
            </div>
            </article><!-- End Team Member -->
        </div>

        <div class="col-md-6 col-lg-3">
            <article class="member-card h-100" data-aos="zoom-in" data-aos-delay="200">
            <figure class="member-media">
                <img src="assets/img/person/person-m-7.webp" class="img-fluid" alt="Team member portrait">
                <ul class="social-list">
                <li><a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a></li>
                <li><a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="#" aria-label="Dribbble"><i class="bi bi-dribbble"></i></a></li>
                </ul>
            </figure>
            <div class="member-content">
                <h3 class="member-name">Logan Rivera</h3>
                <p class="member-role">Lead UX Designer</p>
                <p class="member-bio">Voluptatem repellat omnis, harum veritatis amet. Ullam fugiat beatae quam, nihil officiis.</p>
            </div>
            </article><!-- End Team Member -->
        </div>

        <div class="col-md-6 col-lg-3">
            <article class="member-card h-100" data-aos="zoom-in" data-aos-delay="250">
            <figure class="member-media">
                <img src="assets/img/person/person-f-12.webp" class="img-fluid" alt="Team member portrait">
                <ul class="social-list">
                <li><a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a></li>
                <li><a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="#" aria-label="Behance"><i class="bi bi-behance"></i></a></li>
                </ul>
            </figure>
            <div class="member-content">
                <h3 class="member-name">Mia Patel</h3>
                <p class="member-role">Engineering Manager</p>
                <p class="member-bio">Accusantium quasi obcaecati, ipsum libero minima rem. Dignissimos, asperiores. Nisi, distinctio.</p>
            </div>
            </article><!-- End Team Member -->
        </div>

        <div class="col-md-6 col-lg-3">
            <article class="member-card h-100" data-aos="zoom-in" data-aos-delay="300">
            <figure class="member-media">
                <img src="assets/img/person/person-m-11.webp" class="img-fluid" alt="Team member portrait">
                <ul class="social-list">
                <li><a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a></li>
                <li><a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="#" aria-label="Github"><i class="bi bi-github"></i></a></li>
                </ul>
            </figure>
            <div class="member-content">
                <h3 class="member-name">Ethan Brooks</h3>
                <p class="member-role">Full‑Stack Developer</p>
                <p class="member-bio">Quidem blanditiis recusandae laborum, at molestias id aliquam. Cumque, architecto dolorum.</p>
            </div>
            </article><!-- End Team Member -->
        </div>

        </div>

        {{-- <div class="row g-4 mt-2">
            <div class="col-lg-8">
                <div class="team-highlight d-flex align-items-center" data-aos="fade-right" data-aos-delay="200">
                <div class="icon-wrap">
                    <i class="bi bi-people"></i>
                </div>
                <div class="copy">
                    <h4 class="title">Collaborative crew, measurable impact</h4>
                    <p class="desc mb-0">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa quae ab illo.</p>
                </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex align-items-stretch">
                <aside class="join-card w-100" data-aos="fade-left" data-aos-delay="250">
                <div class="join-content">
                    <h5 class="mb-2">Want to work with us?</h5>
                    <p class="mb-3">Doloribus modi cum repellat. Veniam numquam dicta, laudantium a deleniti sapiente.</p>
                    <a href="#" class="btn btn-join">
                    <i class="bi bi-send me-1"></i>
                    Open Positions
                    </a>
                </div>
                </aside>
            </div>
        </div> --}}

    </div>

</section><!-- /Team Section -->
@include('common.upload_file')

@endsection
@section('scripts')
<script src="{{asset('common/js/upload-file.js')}}"></script>
<script>
    var list1 = [];
    var list2 = [];
    $('#upload-1').click(function(e) {
        _renderUploadFile(list1);
    });
    $('#upload-2').click(function(e) {
        _renderUploadFile(list2);
    })
    
</script>
@endsection
