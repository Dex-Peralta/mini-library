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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Admin Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                
                <!-- Users Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Librarians</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['users']); ?></p>
                            </div>
                            <div class="p-2 bg-indigo-100 rounded-full">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Students</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['students']); ?></p>
                            </div>
                            <div class="p-2 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Authors Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Authors</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['authors']); ?></p>
                            </div>
                            <div class="p-2 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Books</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['books']); ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?php echo e($stats['total_copies']); ?> total copies</p>
                            </div>
                            <div class="p-2 bg-purple-100 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Borrows Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Active Borrows</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['active_borrows']); ?></p>
                                <?php if($stats['overdue_items'] > 0): ?>
                                    <p class="text-xs text-red-600 mt-1"><?php echo e($stats['overdue_items']); ?> overdue</p>
                                <?php endif; ?>
                            </div>
                            <div class="p-2 bg-orange-100 rounded-full">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Charts Section (2x2) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">

                <!-- Book Inventory Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">Book Inventory Status</h3>
                        <div class="h-56">
                            <canvas id="inventoryChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Borrow Status Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">Borrowing Overview</h3>
                        <div class="h-56">
                            <canvas id="borrowChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- System Overview Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">System Overview</h3>
                        <div class="h-56">
                            <canvas id="systemChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Inventory Totals Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-base font-semibold text-gray-900 mb-3">Inventory Totals</h3>
                        <div class="h-56">
                            <canvas id="inventoryTotalsChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inventory Chart (Doughnut)
            const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
            const inventoryChart = new Chart(inventoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Borrowed', 'Reserved'],
                    datasets: [{
                        data: [<?php echo e($stats['available_copies']); ?>, <?php echo e($stats['borrowed_items']); ?>, <?php echo e($stats['reserved_items']); ?>],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(139, 92, 246, 0.8)'
                        ],
                        borderColor: [
                            'rgb(34, 197, 94)',
                            'rgb(249, 115, 22)',
                            'rgb(139, 92, 246)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });

            // Borrow Status Chart (Bar)
            const borrowCtx = document.getElementById('borrowChart').getContext('2d');
            const borrowChart = new Chart(borrowCtx, {
                type: 'bar',
                data: {
                    labels: ['Active Borrows', 'Reserved', 'Overdue Items'],
                    datasets: [{
                        label: 'Count',
                        data: [<?php echo e($stats['active_borrows']); ?>, <?php echo e($stats['reserved_borrows']); ?>, <?php echo e($stats['overdue_items']); ?>],
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            'rgb(99, 102, 241)',
                            'rgb(139, 92, 246)',
                            'rgb(239, 68, 68)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // System Overview Chart (Bar)
            const systemCtx = document.getElementById('systemChart').getContext('2d');
            const systemChart = new Chart(systemCtx, {
                type: 'bar',
                data: {
                    labels: ['Librarians', 'Students', 'Authors', 'Books', 'Active Borrows', 'Reserved'],
                    datasets: [{
                        label: 'Count',
                        data: [
                            <?php echo e($stats['users']); ?>,
                            <?php echo e($stats['students']); ?>,
                            <?php echo e($stats['authors']); ?>,
                            <?php echo e($stats['books']); ?>,
                            <?php echo e($stats['active_borrows']); ?>,
                            <?php echo e($stats['reserved_borrows']); ?>

                        ],
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(139, 92, 246, 0.8)'
                        ],
                        borderColor: [
                            'rgb(99, 102, 241)',
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(168, 85, 247)',
                            'rgb(249, 115, 22)',
                            'rgb(139, 92, 246)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Inventory Totals Chart (Bar)
            const totalsCtx = document.getElementById('inventoryTotalsChart').getContext('2d');
            const inventoryTotalsChart = new Chart(totalsCtx, {
                type: 'bar',
                data: {
                    labels: ['Total Copies', 'Available', 'On Loan'],
                    datasets: [{
                        label: 'Copies',
                        data: [
                            <?php echo e($stats['total_copies']); ?>,
                            <?php echo e($stats['available_copies']); ?>,
                            <?php echo e($stats['borrowed_books']); ?>

                        ],
                        backgroundColor: [
                            'rgba(71, 85, 105, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(249, 115, 22, 0.8)'
                        ],
                        borderColor: [
                            'rgb(71, 85, 105)',
                            'rgb(34, 197, 94)',
                            'rgb(249, 115, 22)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

        });
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH D:\Library management\mini-library\resources\views/admin-dashboard.blade.php ENDPATH**/ ?>