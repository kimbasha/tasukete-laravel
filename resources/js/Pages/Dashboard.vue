<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Card from 'primevue/card';
import Button from 'primevue/button';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalProjects: 12,
            activeTasks: 34,
            completedTasks: 156,
            teamMembers: 8,
        }),
    },
});

const statCards = [
    {
        title: '総プロジェクト数',
        value: 12,
        icon: 'pi pi-folder',
        color: 'text-blue-600',
        bgColor: 'bg-blue-50',
    },
    {
        title: '進行中のタスク',
        value: 34,
        icon: 'pi pi-spin pi-spinner',
        color: 'text-orange-600',
        bgColor: 'bg-orange-50',
    },
    {
        title: '完了したタスク',
        value: 156,
        icon: 'pi pi-check-circle',
        color: 'text-green-600',
        bgColor: 'bg-green-50',
    },
    {
        title: 'チームメンバー',
        value: 8,
        icon: 'pi pi-users',
        color: 'text-purple-600',
        bgColor: 'bg-purple-50',
    },
];
</script>

<template>
    <DashboardLayout>
        <div class="space-y-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">ダッシュボード</h1>
                    <p class="mt-1 text-sm text-gray-500">プロジェクトとタスクの概要</p>
                </div>
                <Button
                    label="新規プロジェクト"
                    icon="pi pi-plus"
                    severity="primary"
                />
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <Card
                    v-for="(stat, index) in statCards"
                    :key="index"
                    class="shadow-sm"
                >
                    <template #content>
                        <div class="flex items-center space-x-4">
                            <div :class="[stat.bgColor, 'p-3 rounded-lg']">
                                <i :class="[stat.icon, stat.color, 'text-2xl']"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">{{ stat.title }}</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stat.value }}</p>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>

            <!-- Welcome Message -->
            <Card class="shadow-sm">
                <template #title>ようこそ</template>
                <template #content>
                    <p class="text-gray-600">
                        基本的なダッシュボードレイアウトが完成しました。
                        サイドバーナビゲーションから各機能にアクセスできます。
                    </p>
                </template>
            </Card>
        </div>
    </DashboardLayout>
</template>
