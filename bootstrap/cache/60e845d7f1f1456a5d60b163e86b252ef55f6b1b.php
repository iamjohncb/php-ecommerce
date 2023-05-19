<?php $categories = \App\models\Category::with('subCategories')->get(); ?>

<header class="navigation">
    <div class="title-bar" data-responsive-toggle="acme-menu" data-hide-for="medium">
        <button class="menu-icon" type="button" data-toggle="acme-menu"></button>
        <div class="title-bar-title"><a href="/">ACME Store</a> </div>
    </div>

    <div class="top-bar" id="acme-menu">
        <div class="top-bar-left">
            <ul class="dropdown menu" data-dropdown-menu>
                <li class="menu-text logo" onclick="location.href='/'"></li>
                <li><a href="/products">Acme Products</a></li>
                <?php if(count($categories)): ?>
                    <li>
                        <a href="/products/category">Categories</a>
                        <ul class="menu vertical dropdown">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="/products/category/<?php echo e($category->slug); ?>"><?php echo e($category->name); ?></a>
                                    <?php if(count($category->subCategories)): ?>
                                        <ul class="menu vertical">
                                            <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a href="/products/category/<?php echo e($category->slug); ?>/<?php echo e($subCategory->slug); ?>">
                                                        <?php echo e($subCategory->name); ?>

                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="top-bar-right">
            <ul class="dropdown menu vertical medium-horizontal">
                <?php if(isAuthenticated()): ?>
                    <li><a href="#"><?php echo e(user()->username); ?></a> </li>
                    <li>
                        <a href="/cart">Cart &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="/logout">Logout</a> </li>
                <?php else: ?>
                    <li><a href="/login">Sign In</a> </li>
                    <li><a href="/register">Register</a> </li>
                    <li>
                        <a href="/cart">Cart &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>
