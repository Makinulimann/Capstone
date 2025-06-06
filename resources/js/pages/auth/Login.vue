<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { toast } from 'vue-sonner'; // Import only toast, not Toaster

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => {
            toast.success('Login successful! Redirecting...', {
                duration: 3000,
            });
        },
        onError: (errors) => {
            const errorMessages = Object.values(errors).flat();
            if (errorMessages.length > 0) {
                toast.error(errorMessages[0], {
                    duration: 5000,
                });
            }
        },
    });
};
</script>

<template>
    <div class="flex h-screen w-screen">
        <div class="flex w-1/2 flex-col items-center justify-center bg-primary text-white">
            <h1 class="mb-6 text-5xl font-bold tracking-widest">SEKITA</h1>
            <img src="/images/hero.svg" alt="Login Illustration" class="max-w-md" />
        </div>

        <div class="flex w-1/2 items-center justify-center bg-primary">
            <AuthBase title="Masuk" description="Masukkan email dan password untuk melanjutkan progres sertifikasi">
                <Head title="Log in" />

                <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="email"
                                v-model="form.email"
                                placeholder="email@example.com"
                            />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <div class="flex items-center justify-between">
                                <Label for="password">Password</Label>
                                <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm text-primary" :tabindex="5">
                                    Forgot password?
                                </TextLink>
                            </div>
                            <Input
                                id="password"
                                type="password"
                                required
                                :tabindex="2"
                                autocomplete="current-password"
                                v-model="form.password"
                                placeholder="Password"
                            />
                            <InputError :message="form.errors.password" />
                        </div>

                        <div class="flex items-center justify-between">
                            <Label for="remember" class="flex items-center space-x-3">
                                <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                                <span>Remember me</span>
                            </Label>
                        </div>

                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Log in
                        </Button>
                    </div>

                    <div class="text-muted-foreground text-center text-sm">
                        Belum memiliki akun?
                        <TextLink :href="route('register')" :tabindex="5" class="text-primary">Daftar</TextLink>
                    </div>
                </form>
            </AuthBase>
        </div>
    </div>
</template>