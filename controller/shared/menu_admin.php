  <?php 
        $admin = '';
        $index = '';
        $customer = '';
        $product = '';
        $order = '';
        $message = '';
        if($page =='admin_controller'){

            $admin =  'class="menu-top-active"';

        }else if($page == 'index'){

            $index =  'class="menu-top-active"';

        }else if($page == 'customer'){

            $customer =  'class="menu-top-active"';

        }else if($page == 'product'){

            $product =  'class="menu-top-active"';
        }else if ($page == 'order'){

            $order = 'class="menu-top-active"';
        }
        else if ($page == 'message'){

            $message = 'class="menu-top-active"';
        }
        ?>

<section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a <?=$index?> href="index.php">Dashboard</a></li>
                            <li><a <?=$admin?> href="admin.php">Admin users</a></li>
                            <li><a <?=$customer?> href="customer.php">Customer users</a></li>
                            <li><a <?=$product?>  href="product.php">Product</a></li>
                             <li><a <?=$order?>  href="order.php">Order</a></li>
                             <li><a <?=$message?>  href="message.php">Message</a></li>
                            <li><a  href="Logout.php" >Logout</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>