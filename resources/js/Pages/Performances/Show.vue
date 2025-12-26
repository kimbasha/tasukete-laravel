<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    performance: {
        type: Object,
        required: true,
    },
});

const getDayTicketBadge = (hasDayTickets) => {
    return hasDayTickets
        ? { text: '当日券あり', class: 'bg-blue-100 text-blue-800' }
        : { text: '当日券なし', class: 'bg-gray-100 text-gray-600' };
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const weekdays = ['日', '月', '火', '水', '木', '金', '土'];
    const weekday = weekdays[date.getDay()];
    return `${year}年${month}月${day}日(${weekday})`;
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- ヘッダー -->
        <header class="bg-white border-b border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">タスケテ 〜HELP ME!!〜</h1>
                    <Link href="/admin/login" class="text-sm text-gray-600 hover:text-gray-900">
                        管理画面
                    </Link>
                </div>
            </div>
        </header>

        <!-- メインコンテンツ -->
        <main class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
            <!-- 戻るボタン -->
            <div class="mb-6">
                <Link
                    href="/"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    一覧に戻る
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <!-- ポスター画像 -->
                    <div class="md:w-1/3">
                        <div class="aspect-[3/4] bg-gray-200">
                            <img
                                v-if="performance.poster_image_url"
                                :src="performance.poster_image_url"
                                :alt="performance.title"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- 公演情報 -->
                    <div class="md:w-2/3 p-6 md:p-8">
                        <!-- 当日券バッジ -->
                        <span
                            :class="[
                                'inline-block px-3 py-1 text-sm font-medium rounded-full mb-4',
                                getDayTicketBadge(performance.has_day_tickets).class
                            ]"
                        >
                            {{ getDayTicketBadge(performance.has_day_tickets).text }}
                        </span>

                        <!-- タイトル -->
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">
                            {{ performance.title }}
                        </h2>

                        <!-- 公演詳細情報（基本情報を上に） -->
                        <div class="space-y-3 mb-6">
                            <!-- 日時 -->
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">{{ formatDate(performance.performance_date) }}</p>
                                    <p class="text-sm text-gray-600">
                                        <template v-if="performance.door_open_time">
                                            開場 {{ performance.door_open_time }} / 開演 {{ performance.start_time }}
                                        </template>
                                        <template v-else>
                                            開演 {{ performance.start_time }}
                                        </template>
                                    </p>
                                </div>
                            </div>

                            <!-- 会場 -->
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">{{ performance.venue }}</p>
                                    <p class="text-sm text-gray-600">{{ performance.area }}</p>
                                </div>
                            </div>

                            <!-- 料金 -->
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-xl font-bold text-gray-900">
                                    ¥{{ performance.ticket_price.toLocaleString() }}
                                </p>
                            </div>
                        </div>

                        <!-- 公演説明 -->
                        <div v-if="performance.description" class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">公演について</h3>
                            <p class="text-gray-700 whitespace-pre-wrap">{{ performance.description }}</p>
                        </div>

                        <!-- 劇団情報 -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ performance.troupe.name }}
                            </h3>
                            <p v-if="performance.troupe.description" class="text-sm text-gray-600 mb-2">
                                {{ performance.troupe.description }}
                            </p>
                            <a
                                v-if="performance.troupe.website"
                                :href="performance.troupe.website"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                公式サイト
                            </a>
                        </div>

                        <!-- 予約ボタン -->
                        <a
                            v-if="performance.reservation_url"
                            :href="performance.reservation_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="block w-full text-center px-6 py-4 mb-4 bg-blue-600 text-white font-medium text-lg rounded-lg hover:bg-blue-700 transition-colors shadow-lg"
                        >
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            予約サイトへ
                        </a>

                        <!-- 一覧に戻る -->
                        <Link
                            href="/"
                            class="block w-full text-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors"
                        >
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            一覧に戻る
                        </Link>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
