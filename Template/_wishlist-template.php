<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['delete-cart-submit'])){
        $deleteRecord = $Cart->deleteCart($_POST['item_id']);
    }
    if (isset($_POST['cart-submit'])){
        $Cart->saveForLater($_POST['item_id'], saveTable:'cart', fromTable:'wishlist');
    }
}
?>
<section id="cart" class="py-3 mb-5">
    <div class="container-fluid w-75 ">
        <h5 class="font-baloo font-size-20">Wishlist</h5>
        <div class="row">
            <div class="col-sm-9">
                <?php 
                    foreach($product->getData(table: 'wishlist') as $item){
                        $cart = $product->getProduct($item['item_id']);
                        $subToTal[] = array_map(function($item){

                ?>
                <div class="row border-top py-3 mt-3">
                    <div class="col-sm-2">
                        <img src="<?php echo $item['item_image'] ?? "./assets/products/1.png" ?>" class="img-fluid"
                            style="height: 120px;">
                    </div>
                    <div class="col-sm-8">
                        <h5 class="font-baloo font-size-20"><?php echo $item['item_name'] ?></h5>
                        <small>by <?php echo $item['item_brand'] ?></small>
                        <div class="d-flex">
                            <div class="rating text-warning font-size-12">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                            <a href="#" class="px-2 font-rale font-size-14">20534 ratings</a>
                        </div>
                        <div class="qty d-flex pt-2">
                            <form method="post">
                                <input type="hidden" value="<?php echo $item['item_id'] ?? 0 ?>" name="item_id">
                                <button type="submit" name="delete-cart-submit"
                                    class="btn font-baloo text-danger pl-0 pr-3 border-right">Delete</button>
                            </form>

                            <form method="post">
                                <input type="hidden" value="<?php echo $item['item_id'] ?? 0 ?>" name="item_id">
                                <button type="submit" name="cart-submit" class="btn font-baloo text-danger px-3">Add to
                                    Cart</button>
                            </form>


                        </div>
                    </div>
                    <div class="col-sm-2 text-right">
                        <div class="font-size-20 text-danger font-baloo">
                            $ <span class="product_price"
                                data-id="<?php echo $item['item_id'] ?? 0 ?>"><?php echo $item['item_price'] ?></span>
                        </div>
                    </div>
                </div>
                <?php 
                    return $item['item_price'];
                        }, $cart);
                    }
                ?>
            </div>
        </div>
    </div>
</section>