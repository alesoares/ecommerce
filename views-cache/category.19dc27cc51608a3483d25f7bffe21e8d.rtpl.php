<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2><?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">

            <?php $counter1=-1;  if( isset($produts) && ( is_array($produts) || $produts instanceof Traversable ) && sizeof($produts) ) foreach( $produts as $key1 => $value1 ){ $counter1++; ?>


            <div class="col-md-3 col-sm-6">
                <div class="single-shop-product">
                    <div class="product-upper">
                        <img src="/res/site/img/product-2.jpg" alt="">
                    </div>
                    <h2><a href="">Apple new mac book 2015 March :P</a></h2>
                    <div class="product-carousel-price">
                        <ins>$899.00</ins> <del>$999.00</del>
                    </div>  
                    
                    <div class="product-option-shop">
                        <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>
                    </div>                       
                </div>
            </div>
            <?php } ?>


            
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="product-pagination text-center">
                    <nav>
                        <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                            <span aria-hidden="true">»</span>
                            </a>
                        </li>
                        </ul>
                    </nav>                        
                </div>
            </div>
        </div>
    </div>
</div>