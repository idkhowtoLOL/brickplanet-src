<!--
MIT License

Copyright (c) 2022 FoxxoSnoot

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-->



<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-3">
            <h3>Thumbnail</h3>
            <div class="card text-center">
                <div class="card-body">
                    <img src="<?php echo e($user->thumbnail()); ?>">
                    <a href="<?php echo e(route('users.profile', $user->username)); ?>" class="btn btn-block btn-primary mt-2" target="_blank"><i class="fas fa-link"></i> View Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <h3>User Info</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php if(staffUser()->staff('can_view_user_emails')): ?>
                            <div class="col-4"><strong>Email</strong></div>
                            <div class="col-8 text-right"><?php echo e($user->email); ?></div>
                        <?php endif; ?>
                        <div class="col-4"><strong>Verified Email</strong></div>
                        <div class="col-8 text-right"><?php echo e(($user->hasVerifiedEmail()) ? 'Yes' : 'No'); ?></div>
                        <?php if(!in_array($user->id, [1, 2])): ?>
                            <div class="col-3"><strong>Last IP:</strong></div>
                            <div class="col-9 text-right"><?php echo e($user->lastIP()); ?></div>
                        <?php endif; ?>
                        <div class="col-4"><strong>Join Date</strong></div>
                        <div class="col-8 text-right"><?php echo e($user->created_at->format('M d, Y')); ?></div>
                        <div class="col-4"><strong>Last Seen</strong></div>
                        <div class="col-8 text-right"><?php echo e($user->updated_at->format('M d, Y')); ?></div>
                        <div class="col-6"><strong>Forum Posts</strong></div>
                        <div class="col-6 text-right"><?php echo e(number_format($user->forumPostCount())); ?></div>
                        <div class="col-4"><strong>Currency</strong></div>
                        <div class="col-8 text-right"><i class="fas fa-money-bill-alt"></i> <?php echo e(number_format($user->currency)); ?></div>
                        <div class="col-6"><strong>Money Spent</strong></div>
                        <div class="col-6 text-right">$<?php echo e(number_format($user->moneySpent())); ?></div>
                        <?php if($user->hasMembership()): ?>
                            <div class="col-6"><strong>Membership Until</strong></div>
                            <div class="col-6 text-right"><?php echo e($user->membership_until); ?></div>
                        <?php endif; ?>
                        <div class="col-4"><strong>Is Online</strong></div>
                        <div class="col-8 text-right"><?php echo e(($user->online()) ? 'Yes' : 'No'); ?></div>
                        <div class="col-4"><strong>Is Staff</strong></div>
                        <div class="col-8 text-right"><?php echo e(($user->isStaff()) ? 'Yes' : 'No'); ?></div>
                        <div class="col-4"><strong>Status</strong></div>
                        <div class="col-8 text-right">
                            <?php if($user->isBanned()): ?>
                                <span class="badge bg-danger text-white">BANNED</span>
                            <?php elseif(!$user->hasVerifiedEmail()): ?>
                                <span class="badge bg-warning">EMAIL NOT VERIFIED</span>
                            <?php else: ?>
                                <span class="badge bg-success text-white">OK</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <h3>Settings</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"><strong>Accepts Messages</strong></div>
                        <div class="col-6 text-right"><?php echo e(($user->setting->accepts_messages) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Accepts Friends</strong></div>
                        <div class="col-6 text-right"><?php echo e(($user->setting->accepts_friends) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Accepts Trades</strong></div>
                        <div class="col-6 text-right"><?php echo e(($user->setting->accepts_trades) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Public Inventory</strong></div>
                        <div class="col-6 text-right"><?php echo e(($user->setting->public_inventory) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Two Step Enabled</strong></div>
                        <div class="col-6 text-right"><?php echo e(($user->setting->two_step_enabled) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Theme</strong></div>
                        <div class="col-6 text-right"><?php echo e(ucfirst(str_replace(' ', '', $user->setting->theme))); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form action="<?php echo e(route('admin.users.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">

                <?php if(staffUser()->staff('can_ban_users') || staffUser()->staff('can_reset_passwords') || staffUser()->staff('can_edit_user_info')): ?>
                    <h3>Account Actions</h3>
                    <div class="card">
                        <div class="card-body">
                            <?php if(staffUser()->staff('can_ban_users')): ?>
                                <?php if(!$user->isBanned()): ?>
                                    <a href="<?php echo e(route('admin.users.ban.index', $user->id)); ?>" class="btn btn-block btn-outline-danger mb-2">
                                        <i class="fas fa-ban mr-1"></i>
                                        <span>Ban</span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(staffUser()->staff('can_unban_users')): ?>
                                <?php if($user->isBanned()): ?>
                                    <button class="btn btn-block btn-outline-warning mb-2" name="action" value="unban">
                                        <i class="fa fa-ban mr-1"></i>
                                        <span>Unban</span>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(staffUser()->staff('can_ip_ban_users')): ?>
                                <?php if(!$ipBanned): ?>
                                    <button class="btn btn-block btn-outline-danger mb-2" name="action" value="ip_ban">
                                        <i class="fa fa-key mr-1"></i>
                                        <span>Ban IP</span>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(staffUser()->staff('can_ip_unban_users')): ?>
                                <?php if($ipBanned): ?>
                                    <button class="btn btn-block btn-outline-warning mb-2" name="action" value="ip_ban">
                                        <i class="fa fa-key mr-1"></i>
                                        <span>Unban IP</span>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(staffUser()->staff('can_reset_user_passwords')): ?>
                                <button class="btn btn-block btn-outline-danger mb-2" name="action" value="password">
                                    <i class="fa fa-key mr-1"></i>
                                    <span>Reset Password</span>
                                </button>
                            <?php endif; ?>

                            <?php if(staffUser()->staff('can_edit_user_info')): ?>
                                <button class="btn btn-block btn-outline-danger mb-2" name="action" value="scrub_username">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Scrub Username</span>
                                </button>
                                <button class="btn btn-block btn-outline-danger mb-2" name="action" value="scrub_description">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Scrub Description</span>
                                </button>
                                <button class="btn btn-block btn-outline-danger mb-2" name="action" value="scrub_forum_signature">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Scrub Forum Signature</span>
                                </button>
                                <?php if($user->hasMembership()): ?>
                                    <button class="btn btn-block btn-outline-danger mb-2" name="action" value="remove_membership">
                                        <i class="fa fa-trash mr-1"></i>
                                        <span>Remove Membership</span>
                                    </button>
                                <?php endif; ?>
                                <div class="mb-1"></div>
                                <label for="length">Membership</label>
                                <div class="input-group">
                                    <select class="form-control" name="membership_length">
                                        <option value="1_month" selected>1 Month</option>
                                        <option value="3_months">3 Months</option>
                                        <option value="6_months">6 Months</option>
                                        <option value="1_year">1 Year</option>
                                        <option value="forever">Forever</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" name="action" value="grant_membership">Grant</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(staffUser()->staff('can_give_currency') || Auth::user('can_take_currency') || Auth::user('can_give_items') || Auth::user('can_take_items')): ?>
                    <h3>Economy Actions</h3>
                    <div class="card">
                        <div class="card-body">
                            <?php if(staffUser()->staff('can_give_currency') || Auth::user('can_take_currency')): ?>
                                <a href="<?php echo e(route('admin.users.manage.index', ['currency', $user->id])); ?>" class="btn btn-block btn-outline-dark mb-2">
                                    <i class="fas fa-money-bill-alt mr-1"></i>
                                    <span>Manage Currency</span>
                                </a>
                            <?php endif; ?>

                            <?php if(staffUser()->staff('can_give_items') || Auth::user('can_take_items')): ?>
                                <a href="<?php echo e(route('admin.users.manage.index', ['inventory', $user->id])); ?>" class="btn btn-block btn-outline-dark mb-2">
                                    <i class="fas fa-box mr-1"></i>
                                    <span>Manage Inventory</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(staffUser()->staff('can_render_thumbnails')): ?>
                    <h3>Avatar Actions</h3>
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-block btn-outline-dark mb-2" name="action" value="regen">
                                <i class="fas fa-sync mr-1"></i>
                                <span>Regen Avatar</span>
                            </button>
                            <button class="btn btn-block btn-outline-dark mb-2" name="action" value="reset">
                                <i class="fas fa-user mr-1"></i>
                                <span>Set Avatar to Default</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => "User: {$user->username}"
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/users/view.blade.php ENDPATH**/ ?>