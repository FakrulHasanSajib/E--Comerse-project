<div class="latest-products">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>Latest Products</h2>
            <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>
          </div>
        </div>
      </div>
      
      <div class="row"> <!-- Start row here before the foreach loop -->
        @foreach($data as $product)
          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img height="350px" width="150px" src="/productimage/{{$product->image}}" alt=""></a>
              <div class="down-content">
                <a href="#"><h4>{{$product->title}}</h4></a>
                <h6>${{$product->price}}</h6>
                <p>{{$product->description}}</p>
                <span>Reviews (32)</span>
              </div>
            </div>
          </div>
        @endforeach
          <div class="d-flex justify-content-center">
            {!! $data->links() !!}

          </div>

      </div> <!-- Close row after the foreach loop -->
      
    </div>
  </div>
  