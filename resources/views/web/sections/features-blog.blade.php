<section>
    <div class="container-xl p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0 fearture-phone-heading" data-aos="fade-right" data-aos-duration="1000">Bài viết nổi bật</h4>
            <a href="{{ route('web.blog.list') }}" class="view-more" data-aos="fade-left" data-aos-duration="1000">Xem tất cả</a>
        </div>

        <div class="row">
            @forelse($featureBlog as $blog)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-duration="1000">
                    <a href="{{ route('web.blog.detail', $blog->id)}}" class="text-decoration-none text-dark">
                        <div class="card-cus h-100">
                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" class="card-img-top" alt="Bài viết">
                            <div class="card-cus-body">
                                <h5 class="pt-4 ps-2 pe-2 mb-4">{{$blog->title}}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
