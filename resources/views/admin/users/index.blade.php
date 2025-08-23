<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 sm:border-2 sm:border-gray-200 sm:border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- Page header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Users</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage users, filter, sort, and perform bulk actions.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- REFRESH Button --}}
                        <x-secondary-link-button href="{{ url()->current() }}">Refresh</x-secondary-link-button>
                        {{-- C: CREATE PRODUCT Button --}}
                        <x-primary-link-button href="#">Create User</x-primary-link-button>
                    </div>
                </div>
            </div>

            <!-- Flash messages -->
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-800 dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" class="mb-4">
                <div class="grid gap-3 md:grid-cols-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Name or description…" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                        <select name="type" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All</option>
                            @foreach (['pizza','drink','side'] as $t)
                                <option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500">
                            @php $statuses = ['' => 'All', 'active' => 'Active', 'inactive' => 'Inactive', 'trashed' => 'Trashed']; @endphp
                            @foreach ($statuses as $val => $label)
                                <option value="{{ $val }}" @selected(request('status')===$val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort</label>
                        <select name="sort" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500">
                            @php
                                $sorts = [
                                    '' => 'Default',
                                    'name_asc' => 'Name A→Z',
                                    'name_desc' => 'Name Z→A',
                                    'price_asc' => 'Price Low→High',
                                    'price_desc' => 'Price High→Low',
                                    'newest' => 'Newest',
                                    'oldest' => 'Oldest',
                                ];
                            @endphp
                            @foreach ($sorts as $val => $label)
                                <option value="{{ $val }}" @selected(request('sort')===$val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Per Page</label>
                        <select name="per_page" class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500">
                            @foreach ([10,25,50,100] as $pp)
                                <option value="{{ $pp }}" @selected((int)request('per_page', 10)===$pp)>{{ $pp }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white hover:bg-black dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white">Apply</button>
                        <a href="{{ url()->current() }}" class="inline-flex items-center rounded-md border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">Reset</a>{{-- {{ route('admin.products.index') }} --}}
                    </div>
                </div>
            </form>

            <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <select name="action" required class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Bulk actions</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="delete">Soft Delete</option>
                        <option value="restore">Restore</option>
                        <option value="force_delete">Permanently Delete</option>
                    </select>
                    <button type="submit" class="inline-flex items-center rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">Apply</button>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ number_format($users->total()) }} total
                </div>
            </div>

            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="w-10 px-3 py-2">
                                <input id="select-all" type="checkbox" class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                            </th>
                            <th class="w-12 px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Image</th>
                            <th class="w-72 px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Name</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Phone</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-900">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/60">
                                <td class="px-3 py-2 align-middle">
                                    <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="row-check h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                                </td>
                                <td class="w-12 px-3 py-2 align-middle">
                                    <img src="{{ $user->profile_photo_path ? asset($user->profile_photo_path) : 'https://placehold.co/64x64.png' }}" alt="" class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                                </td>
                                <td class="w-72 px-3 py-2 align-middle">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                    @if($user->email)
                                        <div class="mt-0.5 line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    @endif
                                </td>
                                <td class="px-3 py-2 align-left">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->phone }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No products found. Try adjusting your filters.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div>
                    <div class="sm:hidden">
                        Showing
                        <span class="font-medium">{{ $users->firstItem() ?: 0 }}</span>
                        to
                        <span class="font-medium">{{ $users->lastItem() ?: 0 }}</span>
                        of
                        <span class="font-medium">{{ $users->total() }}</span>
                        results
                    </div>
                </div>
                <div class="flex items-center">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
    </div>
    <!-- Select all (vanilla JS, no dependency) -->
    <script>
        (function () {
            const all = document.getElementById('select-all');
            const rows = Array.from(document.querySelectorAll('.row-check'));
            if (!all || rows.length === 0) return;
            all.addEventListener('change', () => {
                rows.forEach(cb => cb.checked = all.checked);
            });
        })();
    </script>
</x-admin-layout>
