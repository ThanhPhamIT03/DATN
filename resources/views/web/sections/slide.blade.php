<section id="slide-banner">
    <div class="slide-container" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="300">
        <a href="#"><img src="{{ asset('./images/banner-ip16.webp')}}" class="banner-img"></a>
        <a href="#"><img src="{{ asset('./images/banner-ip16(1).webp')}}" class="banner-img"></a>
        <a href="#"><img src="{{ asset('./images/banner-samsung.webp')}}" class="banner-img"></a>
        <a href="#"><img src="{{ asset('./images/banner-xaomi.jpg')}}" class="banner-img"></a>
        <a href="#"><img src="{{ asset('./images/banner.png')}}" class="banner-img"></a>
    </div>
</section>

<style>
    #slide-banner {
        height: 70vh;
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
