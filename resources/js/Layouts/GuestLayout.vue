<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
const mobileMenuOpen = ref(false);

const navigation = [
    { name: '機能', href: '#features' },
    { name: '料金', href: '#pricing' },
    { name: 'お問い合わせ', href: '#contact' },
];
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white border-b border-gray-200">
            <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <Link href="/" class="text-2xl font-bold text-blue-600">
                            {{ page.props.appName || 'Laravel' }}
                        </Link>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-8">
                        <a
                            v-for="item in navigation"
                            :key="item.name"
                            :href="item.href"
                            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors"
                        >
                            {{ item.name }}
                        </a>
                        <Link
                            href="/dashboard"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors"
                        >
                            ダッシュボード
                        </Link>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex md:hidden">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                        >
                            <span class="sr-only">メニューを開く</span>
                            <svg
                                v-if="!mobileMenuOpen"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg
                                v-else
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-200">
                    <div class="space-y-1 px-2 pb-3 pt-2">
                        <a
                            v-for="item in navigation"
                            :key="item.name"
                            :href="item.href"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100"
                        >
                            {{ item.name }}
                        </a>
                        <Link
                            href="/dashboard"
                            class="block rounded-md bg-blue-600 px-3 py-2 text-base font-medium text-white hover:bg-blue-700"
                        >
                            ダッシュボード
                        </Link>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            {{ page.props.appName || 'Laravel' }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            プロジェクト管理を効率化し、チームの生産性を向上させます。
                        </p>
                    </div>

                    <!-- Links -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-4">製品</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-600 hover:text-blue-600">機能</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-blue-600">料金</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-blue-600">FAQ</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 mb-4">サポート</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-600 hover:text-blue-600">ヘルプセンター</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-blue-600">お問い合わせ</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-blue-600">利用規約</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center">
                        &copy; {{ new Date().getFullYear() }} {{ page.props.appName || 'Laravel' }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
