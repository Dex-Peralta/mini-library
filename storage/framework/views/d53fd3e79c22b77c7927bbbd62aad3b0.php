<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Borrow Transactions</h2>
            <a href="<?php echo e(route('borrows.create')); ?>" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                New Borrow
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <?php if($borrows->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Books</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $borrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $totalItems = $borrow->items->count();
                                            $returnedItems = $borrow->items->where('returned_at', '!=', null)->count();
                                            $overdueItems = $borrow->items->filter(function($item) use ($borrow) {
                                                return !$item->returned_at && now()->greaterThan($borrow->due_date);
                                            })->count();
                                            
                                            if ($returnedItems == $totalItems) {
                                                $status = 'Returned';
                                                $statusClass = 'bg-green-100 text-green-800';
                                            } elseif ($returnedItems > 0) {
                                                $status = 'Partially Returned';
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                            } elseif ($overdueItems > 0) {
                                                $status = 'Overdue';
                                                $statusClass = 'bg-red-100 text-red-800';
                                            } else {
                                                $status = 'Borrowed';
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                            }
                                        ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #<?php echo e($borrow->id); ?>

                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div><?php echo e($borrow->student->name); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo e($borrow->student->student_number); ?></div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <?php echo e($totalItems); ?> book(s)
                                                <?php if($returnedItems > 0): ?>
                                                    <br><span class="text-xs">(<?php echo e($returnedItems); ?> returned)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($borrow->borrow_date->format('M d, Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($borrow->due_date->format('M d, Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusClass); ?>">
                                                    <?php echo e($status); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="<?php echo e(route('borrows.show', $borrow->id)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                <?php if($returnedItems < $totalItems): ?>
                                                    <a href="<?php echo e(route('borrows.return', $borrow->id)); ?>" class="text-green-600 hover:text-green-900">Return</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new borrow transaction.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('borrows.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-700">
                                    New Borrow
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\Library management\mini-library\resources\views/borrows/index.blade.php ENDPATH**/ ?>