<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('data-page-id', 'adminUsers'); ?>

<?php $__env->startSection('content'); ?>
    <div class="users admin_shared">
        <div class="grid-padding-x">
            <div class="cell medium-11">
                <h2>Users</h2> <hr />
            </div>
        </div>

        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-11 cell">
                <?php if(count($users)): ?>
                    <table class="hover unstriped">
                        <tbody>
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Date Created</th>
                        </tr>
                        </thead>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user['username']); ?></td>
                                <td><?php echo e($user['fullname']); ?></td>
                                <td><?php echo e($user['email']); ?></td>
                                <td><?php echo e($user['address']); ?></td>
                                <td style="display: flex; justify-content: space-between">
                                    <?php echo e($user['role']); ?>

                                    <span data-tooltip aria-haspopup="true"
                                          class="has-tip top" data-disable-hover="false"
                                          tabindex="1" title="Edit Product">
                                    <a data-open="item-<?php echo e($user['id']); ?>"><i class="fa fa-edit"></i></a>
                                    </span>


                                    <!-- Edit Role Modal -->
                                    <div class="reveal" id="item-<?php echo e($user['id']); ?>"
                                         data-reveal data-close-on-click="false" data-close-on-esc="false"
                                         data-animation-in="fade-in" data-animation-out="scale-out-up">
                                        <div class="notification callout primary">notif</div>
                                        <h2>Edit Role</h2>
                                        <form>
                                            <div class="input-group" style="display: block">
                                                <select id="item-<?php echo e($user['id']); ?>">
                                                    <option value="user" <?php echo e($user['role'] === 'user' ? 'selected' : ''); ?>>User</option>
                                                    <option value="admin" <?php echo e($user['role'] === 'admin' ? 'selected' : ''); ?>>Admin</option>
                                                </select>
                                                <div>
                                                    <input type="submit" class="button update-role"
                                                           id="update-role-<?php echo e($user['id']); ?>"
                                                           data-token="<?php echo e(\App\classes\CSRFToken::_token()); ?>"
                                                           value="Update">
                                                </div>
                                            </div>
                                        </form>
                                        <a href="/admin/users" class="close-button" data-close aria-label="Close modal" type="button">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                    <!-- End Edit Role Modal -->


                                </td>
                                <td><?php echo e($user['added']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo $links; ?>

                <?php else: ?>
                    <h2>You have not any registered user.</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>