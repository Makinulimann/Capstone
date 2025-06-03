<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Mail, CheckCircle, ArrowLeft } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};
</script>

<template>
    <AuthLayout>
        <Head title="Verify Your Email" />

        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary/5 via-background to-secondary/10 px-4 py-8">
            <div class="w-full max-w-md">
                <!-- Card Container -->
                <div class="bg-card border border-border rounded-2xl shadow-xl overflow-hidden backdrop-blur-sm">
                    <!-- Header Section -->
                    <div class="bg-gradient-to-r from-primary to-primary/80 px-8 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-6 backdrop-blur-sm">
                            <Mail class="h-8 w-8 text-primary-foreground" />
                        </div>
                        <h1 class="text-2xl font-bold text-primary-foreground mb-2">
                            Verify Your Email
                        </h1>
                        <p class="text-primary-foreground/90 text-sm leading-relaxed">
                            We've sent a verification link to your email address. Please check your inbox and click the link to activate your account.
                        </p>
                    </div>

                    <!-- Content Section -->
                    <div class="px-8 py-8">
                        <!-- Success Message -->
                        <div v-if="status === 'verification-link-sent'" 
                             class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-in fade-in duration-500">
                            <CheckCircle class="h-5 w-5 text-green-600 flex-shrink-0" />
                            <p class="text-sm text-green-800 font-medium">
                                A new verification link has been sent to your email address.
                            </p>
                        </div>

                        <!-- Instructions -->
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-semibold text-primary">1</span>
                                </div>
                                <p class="text-sm text-muted-foreground">
                                    Check your email inbox (and spam folder)
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-semibold text-primary">2</span>
                                </div>
                                <p class="text-sm text-muted-foreground">
                                    Click the verification link in the email
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-semibold text-primary">3</span>
                                </div>
                                <p class="text-sm text-muted-foreground">
                                    Return to login once verified
                                </p>
                            </div>
                        </div>

                        <!-- Resend Form -->
                        <form @submit.prevent="submit" class="space-y-6">
                            <Button 
                                :disabled="form.processing" 
                                variant="secondary"
                                class="w-full h-12 font-medium transition-all duration-200 hover:scale-[0.98] active:scale-95"
                            >
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                                <Mail v-else class="h-4 w-4 mr-2" />
                                {{ form.processing ? 'Sending...' : 'Resend Verification Email' }}
                            </Button>
                        </form>

                        <!-- Divider -->
                        <div class="flex items-center gap-4 my-6">
                            <div class="flex-1 h-px bg-border"></div>
                            <span class="text-xs text-muted-foreground font-medium">OR</span>
                            <div class="flex-1 h-px bg-border"></div>
                        </div>

                        <!-- Back to Login -->
                        <TextLink 
                            :href="route('login')"
                            class="flex items-center justify-center gap-2 w-full py-3 px-4 text-sm font-medium text-muted-foreground hover:text-primary transition-colors duration-200 border border-border rounded-xl hover:border-primary/30 hover:bg-primary/5"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Back to Login
                        </TextLink>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-muted-foreground">
                        Having trouble? Check your spam folder or contact support.
                    </p>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-in {
    animation: fade-in 0.5s ease-out;
}
</style>