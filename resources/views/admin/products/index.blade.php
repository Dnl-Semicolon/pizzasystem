<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 sm:border-2 sm:border-gray-200 sm:border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- Page header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Products</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage products, filter, sort, and perform bulk actions.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- REFRESH Button --}}
                        <x-secondary-link-button href="{{ url()->current() }}">Refresh</x-secondary-link-button>
                        {{-- C: CREATE PRODUCT Button --}}
                        <x-primary-link-button href="#">Create Product</x-primary-link-button>
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

            <!-- Bulk actions + table -->
            {{--<form method="POST" action="{{ route('admin.products.bulk') }}">
                @csrf
            --}}
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
                        {{ number_format($products->total()) }} total
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
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Image</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300 w-96">Name</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300 w-20">Type</th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Price (RM)</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Updated</th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-300">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-900">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/60">
                                    <td class="px-3 py-2 align-top">
                                        <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="row-check h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <img src="{{ $product->image_url ? asset($product->image_url) : 'https://placehold.co/64x64.png' }}" alt="" class="h-10 w-10 rounded object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                                    </td>
                                    <td class="px-3 py-2 align-top w-96">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                                        @if($product->description)
                                            <div class="mt-0.5 line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ $product->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 align-top w-20">
                                            <span
                                                @class([
                                                    'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-gray-700 ring-gray-300 bg-gray-50' => $product->type === 'side',
                                                    'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-blue-700 ring-blue-300 bg-blue-50' => $product->type === 'drink',
                                                    'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-amber-700 ring-amber-300 bg-amber-50' => $product->type === 'pizza',
                                                ])>
                                                {{ ucfirst($product->type) }}
                                            </span>
                                    </td>
                                    <td class="px-3 py-2 text-right align-top text-gray-900 dark:text-gray-100">
                                        {{ number_format($product->price, 2) }}
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        @php $active = (bool) $product->is_active; @endphp
                                        <span   @class([
                                                    'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-300' => $active,
                                                    'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-300' => ! $active,
                                                ])>
                                                <span @class(['h-1.5 w-1.5 rounded-full bg-green-600'=> $active, 'h-1.5 w-1.5 rounded-full bg-gray-500'=> ! $active])></span>
                                                {{ $active ? 'Active' : 'Inactive' }}
                                            </span>

                                        @if(method_exists($product, 'trashed') && $product->trashed())
                                            <span class="ml-2 inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-300">Trashed</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 align-top text-sm text-gray-500 dark:text-gray-400">
                                        {{ $product->updated_at?->diffForHumans() }}
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <div class="flex justify-end gap-2">
                                            @if($product->type === 'pizza')
                                                <a href="{{ route('pizzas.show', $product->pizza->id) }}" class="rounded-md border border-gray-300 px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">View</a>{{--{{ route('admin.products.show', $product) }}--}}
                                            @else
                                                <a href="#" class="rounded-md border border-gray-300 px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">View</a>{{--{{ route('admin.products.show', $product) }}--}}
                                            @endif
        {{--                                    <a href="#" class="rounded-md border border-gray-300 px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">View</a>--}}{{--{{ route('admin.products.show', $product) }}--}}
                                            <a href="#" class="rounded-md bg-blue-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-blue-700">Edit</a>{{--{{ route('admin.products.edit', $product) }}--}}

                                            @if(method_exists($product, 'trashed') && $product->trashed())
                                                <form method="POST">{{--{{ route('admin.products.restore', $product->id) }}--}}
                                                    @csrf
                                                    <button type="submit" class="rounded-md bg-emerald-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">Restore</button>
                                                </form>
                                                <form method="POST" onsubmit="return confirm('Permanently delete this product? This cannot be undone.');">{{--{{ route('admin.products.force-destroy', $product->id) }}--}}
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="rounded-md bg-red-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-red-700">Delete</button>
                                                </form>
                                            @else
                                                <form method="POST" onsubmit="return false; return confirm('Move this product to trash?');">{{--{{ route('admin.products.destroy', $product) }}--}}
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="rounded-md bg-red-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-red-700">Trash</button>
                                                </form>
                                            @endif
                                        </div>
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

                    <!-- Pagination -->
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                        <div>
                            <div class="sm:hidden">
                                Showing
                                <span class="font-medium">{{ $products->firstItem() ?: 0 }}</span>
                                to
                                <span class="font-medium">{{ $products->lastItem() ?: 0 }}</span>
                                of
                                <span class="font-medium">{{ $products->total() }}</span>
                                results
                            </div>
                        </div>
                        <div class="flex items-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            {{--</form>--}}
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
