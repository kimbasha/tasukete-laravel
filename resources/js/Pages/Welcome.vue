<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';

const features = [
    {
        name: 'プロジェクト管理',
        description: 'タスクの進捗を可視化し、プロジェクト全体を効率的に管理できます。',
        icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    },
    {
        name: 'チーム協業',
        description: 'メンバー間のコミュニケーションを促進し、チームワークを向上させます。',
        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
    },
    {
        name: 'リアルタイム更新',
        description: '変更がすぐに反映され、常に最新の情報を確認できます。',
        icon: 'M13 10V3L4 14h7v7l9-11h-7z',
    },
];
</script>

<template>
    <GuestLayout>
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-b from-blue-50 to-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        プロジェクト管理を<br>もっとシンプルに
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 max-w-2xl mx-auto">
                        チームの生産性を最大化する、直感的なプロジェクト管理ツール。
                        タスク管理から進捗追跡まで、すべてを一箇所で。
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <Link
                            href="/dashboard"
                            class="rounded-lg bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-blue-700 transition-colors"
                        >
                            今すぐ始める
                        </Link>
                        <a
                            href="#features"
                            class="text-base font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors"
                        >
                            詳しく見る <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 sm:py-32 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        主な機能
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        効率的なプロジェクト管理に必要なすべてが揃っています
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="feature in features"
                        :key="feature.name"
                        class="relative p-8 bg-gray-50 rounded-2xl hover:shadow-lg transition-shadow"
                    >
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-600 text-white mb-6">
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    :d="feature.icon"
                                />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ feature.name }}
                        </h3>
                        <p class="text-gray-600">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-blue-600">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        今すぐ始めましょう
                    </h2>
                    <p class="mt-4 text-lg text-blue-100">
                        無料で始められます。クレジットカード不要。
                    </p>
                    <div class="mt-8">
                        <Link
                            href="/dashboard"
                            class="inline-block rounded-lg bg-white px-6 py-3 text-base font-semibold text-blue-600 shadow-sm hover:bg-gray-50 transition-colors"
                        >
                            無料で始める
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
