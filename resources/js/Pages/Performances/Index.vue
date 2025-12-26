<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    performances: {
        type: Array,
        default: () => [],
    },
});

// フィルター状態
const dateFilter = ref('all');
const areaFilter = ref('all');

// 日付フィルターのオプション
const dateFilterOptions = [
    { label: 'すべて', value: 'all' },
    { label: '今日', value: 'today' },
    { label: '明日', value: 'tomorrow' },
    { label: '週末', value: 'weekend' },
];

// エリアフィルターのオプション
const areaFilterOptions = [
    { label: 'すべて', value: 'all' },
    { label: '下北沢', value: '下北沢' },
    { label: '新宿', value: '新宿' },
    { label: '渋谷', value: '渋谷' },
    { label: '池袋', value: '池袋' },
    { label: 'その他', value: 'その他' },
];

// フィルター済み公演リスト
const filteredPerformances = computed(() => {
    let result = props.performances;

    // 日付フィルター
    if (dateFilter.value !== 'all') {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        result = result.filter(perf => {
            const perfDate = new Date(perf.performance_date);
            perfDate.setHours(0, 0, 0, 0);

            if (dateFilter.value === 'today') {
                return perfDate.getTime() === today.getTime();
            } else if (dateFilter.value === 'tomorrow') {
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                return perfDate.getTime() === tomorrow.getTime();
            } else if (dateFilter.value === 'weekend') {
                const day = perfDate.getDay();
                return day === 0 || day === 6; // 日曜日または土曜日
            }
            return true;
        });
    }

    // エリアフィルター
    if (areaFilter.value !== 'all') {
        result = result.filter(perf => perf.area === areaFilter.value);
    }

    return result;
});

const getDayTicketBadge = (hasDayTickets) => {
    return hasDayTickets
        ? { text: '当日券あり', class: 'bg-blue-100 text-blue-800' }
        : { text: '当日券なし', class: 'bg-gray-100 text-gray-600' };
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const weekdays = ['日', '月', '火', '水', '木', '金', '土'];
    const weekday = weekdays[date.getDay()];
    return `${month}/${day}(${weekday})`;
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
        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <!-- タイトルとフィルター -->
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">今日の公演</h2>
                <p class="mt-1 text-gray-600">当日券の情報をチェック</p>
            </div>

            <!-- フィルターセクション -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- 日付フィルター -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            日付で絞り込み
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="option in dateFilterOptions"
                                :key="option.value"
                                @click="dateFilter = option.value"
                                :class="[
                                    'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                                    dateFilter === option.value
                                        ? 'bg-blue-600 text-white'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                ]"
                            >
                                {{ option.label }}
                            </button>
                        </div>
                    </div>

                    <!-- エリアフィルター -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            エリアで絞り込み
                        </label>
                        <select
                            v-model="areaFilter"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option
                                v-for="option in areaFilterOptions"
                                :key="option.value"
                                :value="option.value"
                            >
                                {{ option.label }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- フィルター結果の表示 -->
                <div class="mt-4 text-sm text-gray-600">
                    {{ filteredPerformances.length }}件の公演が見つかりました
                </div>
            </div>

            <!-- 公演カード一覧 -->
            <div v-if="filteredPerformances.length === 0" class="text-center py-12">
                <p class="text-gray-500">条件に合う公演が見つかりませんでした</p>
            </div>

            <div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="performance in filteredPerformances"
                    :key="performance.id"
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
                >
                    <!-- ポスター -->
                    <div class="aspect-[3/4] bg-gray-200">
                        <img
                            v-if="performance.poster_image_url"
                            :src="performance.poster_image_url"
                            :alt="performance.title"
                            class="w-full h-full object-cover"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- 公演情報 -->
                    <div class="p-4">
                        <span
                            :class="[
                                'inline-block px-2 py-1 text-xs font-medium rounded-full mb-2',
                                getDayTicketBadge(performance.has_day_tickets).class
                            ]"
                        >
                            {{ getDayTicketBadge(performance.has_day_tickets).text }}
                        </span>

                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ performance.title }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-3">
                            {{ performance.troupe_name }}
                        </p>

                        <div class="space-y-1 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ formatDate(performance.performance_date) }} {{ performance.start_time }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ performance.venue }} ({{ performance.area }})</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>¥{{ performance.ticket_price.toLocaleString() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
