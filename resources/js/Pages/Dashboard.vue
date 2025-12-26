<script setup>
import { usePage, router } from '@inertiajs/vue3';
import Button from 'primevue/button';

const page = usePage();
const props = defineProps({
    stats: Object,
});

const logout = () => {
    router.post('/admin/logout');
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- ヘッダー -->
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">管理画面ダッシュボード</h1>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600">
                        {{ page.props.auth.admin?.email }}
                    </div>
                    <Button
                        label="ログアウト"
                        icon="pi pi-sign-out"
                        severity="secondary"
                        @click="logout"
                    />
                </div>
            </div>
        </header>

        <!-- メインコンテンツ -->
        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="pi pi-folder text-3xl text-blue-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        総プロジェクト数
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        {{ stats?.totalProjects || 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="pi pi-check-square text-3xl text-green-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        アクティブタスク
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        {{ stats?.activeTasks || 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="pi pi-check-circle text-3xl text-purple-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        完了タスク
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        {{ stats?.completedTasks || 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="pi pi-users text-3xl text-orange-600"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        チームメンバー
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        {{ stats?.teamMembers || 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">ようこそ、管理画面へ</h2>
                <p class="text-gray-600">
                    ログイン成功しました。認証機能が正常に動作しています。
                </p>
            </div>
        </main>
    </div>
</template>
