<script setup>
import { useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import Message from 'primevue/message';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/admin/login', {
        onFinish: () => {
            form.password = '';
        },
    });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- ロゴ・タイトル -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        タスケテ 〜HELP ME!!〜
                    </h1>
                    <p class="text-gray-600">管理画面</p>
                </div>

                <!-- エラーメッセージ -->
                <Message
                    v-if="form.errors.email"
                    severity="error"
                    :closable="false"
                    class="mb-4"
                >
                    {{ form.errors.email }}
                </Message>

                <!-- ログインフォーム -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- メールアドレス -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            メールアドレス
                        </label>
                        <InputText
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="admin@example.com"
                            class="w-full"
                            :class="{ 'p-invalid': form.errors.email }"
                            required
                            autofocus
                        />
                    </div>

                    <!-- パスワード -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            パスワード
                        </label>
                        <Password
                            id="password"
                            v-model="form.password"
                            placeholder="パスワードを入力"
                            :feedback="false"
                            toggleMask
                            class="w-full"
                            :class="{ 'p-invalid': form.errors.password }"
                            inputClass="w-full"
                            required
                        />
                    </div>

                    <!-- ログイン状態を保持 -->
                    <div class="flex items-center">
                        <Checkbox
                            id="remember"
                            v-model="form.remember"
                            :binary="true"
                        />
                        <label for="remember" class="ml-2 text-sm text-gray-700 cursor-pointer">
                            ログイン状態を保持する
                        </label>
                    </div>

                    <!-- ログインボタン -->
                    <Button
                        type="submit"
                        label="ログイン"
                        icon="pi pi-sign-in"
                        class="w-full"
                        :loading="form.processing"
                    />
                </form>

                <!-- フッター -->
                <div class="mt-6 text-center">
                    <a href="/" class="text-sm text-gray-600 hover:text-gray-900">
                        公開ページに戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
