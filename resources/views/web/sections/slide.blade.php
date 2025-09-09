<section id="slide-banner">
    <div class="slide-container" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="300">
        @foreach ($banners as $banner)
            <a href="{{ $banner->link }}">
                <img src="{{ asset('storage/' . $banner->image) }}" class="banner-img" alt="{{ $banner->title }}">
            </a>
        @endforeach
    </div>
</section>

<style>
    #slide-banner {
        height: 85vh;
        overflow: hidden;
        position: relative;
        margin-bottom: 32px;
    }

    .slide-container {
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.5s ease-in-out;
    }

    .slide-container a {
        flex: 0 0 100%;
        height: 100%;
    }

    .banner-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }
</style>
