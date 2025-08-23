<div class="space-y-6">
    <!-- Update Password -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Password & Security</h3>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <!-- Two-Factor Authentication (Future Feature) -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Two-Factor Authentication</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Add an extra layer of security to your account</p>
                </div>
                <button type="button" disabled class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 cursor-not-allowed">
                    Enable 2FA
                </button>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Coming Soon</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>Two-factor authentication will be available soon for enhanced account security.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Activity (Future Feature) -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="p-6">
            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Login Activity</h4>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Login tracking coming soon</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We'll show you recent login activity to help keep your account secure.</p>
            </div>
        </div>
    </div>

    <!-- Delete Account -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-6">Danger Zone</h3>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>