<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';

const page = usePage();
const sidebarOpen = ref(true);

const navigation = [
    { name: 'ダッシュボード', href: '/dashboard', icon: 'pi pi-home' },
    { name: 'プロジェクト', href: '/projects', icon: 'pi pi-folder' },
    { name: 'タスク', href: '/tasks', icon: 'pi pi-check-square' },
    { name: '設定', href: '/settings', icon: 'pi pi-cog' },
];

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside
            :class="[
                'fixed top-0 left-0 z-40 h-screen transition-transform',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
                'w-64 bg-white border-r border-gray-200'
            ]"
        >
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800">
                    {{ page.props.appName || 'Laravel' }}
                </h1>
                <Button
                    icon="pi pi-times"
                    text
                    rounded
                    class="lg:hidden"
                    @click="toggleSidebar"
                />
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        'flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors',
                        $page.url === item.href
                            ? 'bg-primary text-white'
                            : 'text-gray-700 hover:bg-gray-100'
                    ]"
                >
                    <i :class="[item.icon, 'mr-3']"></i>
                    {{ item.name }}
                </Link>
            </nav>

            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <Avatar
                        icon="pi pi-user"
                        class="bg-primary text-white"
                        shape="circle"
                    />
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ page.props.auth?.user?.name || 'ユーザー' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ page.props.auth?.user?.email || 'user@example.com' }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div :class="['lg:ml-64', 'transition-all']">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <Button
                        icon="pi pi-bars"
                        text
                        rounded
                        @click="toggleSidebar"
                    />

                    <div class="flex items-center space-x-4">
                        <Button
                            icon="pi pi-bell"
                            text
                            rounded
                            severity="secondary"
                        />
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                        >
                            <Button
                                icon="pi pi-sign-out"
                                label="ログアウト"
                                text
                                severity="secondary"
                            />
                        </Link>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>

        <!-- Mobile Overlay -->
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden"
            @click="toggleSidebar"
        />
    </div>
</template>

<style scoped>
.bg-primary {
    background-color: var(--primary-color);
}

.text-primary {
    color: var(--primary-color);
}
</style>
