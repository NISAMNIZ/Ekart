@extends('users.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">{{$product->name}}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            <!-- <div class="carousel-item">
                                <img class="w-100 h-100" src="images/product-1.jpg" alt="Image">
                            </div> -->
                            @if ($product->image)
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{asset("storage/images/".$product->image) }}" alt="Image">
                            </div>
                            @else
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{asset("storage/images/no_image_available_1.jpg") }}" alt="Image">
                            </div>
                            @endif
                            <!-- <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{asset("storage/images/".$product->image) }}" alt="Image">
                            </div> -->
                            <!-- <div class="carousel-item">
                                <img class="w-100 h-100" src="images/product-3.jpg" alt="Image">
                            </div>
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="images/product-4.jpg" alt="Image">
                            </div> -->
                        </div>
                        <!-- <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a> -->
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{ucwords($product->name)}}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        @if ($product->compare_price && $product->compare_price > 0)
                        <h2 class="price text-secondary"><del>$400</del></h2>
                        @endif
                        
                        <h2 class="price ">{{$product->price}}</h2>

                        <p style="color: black;">{{$product->short_description ?? 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolor aut nihil iste porro ullam repellendus inventore voluptatem nam veritatis exercitationem doloribus voluptates dolorem nobis voluptatum qui, minus facere'}}</p>
                        <a href="javascript:void(0);" onclick=addToCart({{$product->id}}) class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p style="color: black;">
                               {{$product->description}}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p style="color: black;">{{$product->shipping_returns ?? 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolor aut nihil iste porro ullam repellendus inventore voluptatem nam veritatis exercitationem doloribus voluptates dolorem nobis voluptatum qui, minus facere'}}</p>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <p style="color: black;">dfdffd</p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>           
        </div>
    </section>
@if($relatedProducts)
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div> 
            <div class="col-md-12" style="margin-bottom: 100px;">
                <div id="related-products" class="carousel">
                    @foreach ($relatedProducts as $relatedProduct)
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            @if ($relatedProduct->image)
                            <a href="" class="product-img"><img class="card-img-top" src="{{asset("storage/images/".$relatedProduct->image) }}" alt=""></a>
                            @else
                            <a href="" class="product-img"><img class="card-img-top" src="{{asset("storage/images/no_image_available_1.jpg") }}" alt=""></a>
                            @endif
                           
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>                            
                            </div>
                        </div>                        
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">{{$relatedProduct->name}}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>${{$relatedProduct->price}}</strong></span>
                                @if ($relatedProduct->compare_price)
                                <span class="h6 text-underline"><del>${{$relatedProduct->compare_price}}</del></span>
                                @endif
                            </div>
                        </div>                        
                    </div> 
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
<script>
    // function addToCart(id){
    //     $.post('{{route('user.addToCart')}}',{id:id},function (response) {
    //         if (response.status == true) {
    //             window.location.href= "{{ route('user.cart') }}";
    //         }else{
    //             toastr.error(response.message);
    //         }
    //     }).fail(function (response) {
    //         toastr.error(response.message);
    //     });;
    // }
</script>
@endsection