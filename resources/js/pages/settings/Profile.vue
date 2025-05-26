<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    photo: null as File | null, // Initialize photo as null (file input)
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset('photo'), // Reset file input after successful upload
    });
};

// Reference to the file input for triggering it via the button
const fileInput = ref<HTMLInputElement | null>(null);

const triggerFileInput = () => {
    if (fileInput.value) {
        fileInput.value.click(); // Trigger the hidden file input
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading title="Profil" description="Informasi Profil Pengguna" />

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Photo Section -->
                    <div class="grid gap-2">
                        <div class="flex items-center gap-4">
                            <img
                                v-if="user.photo"
                                :src="'/storage/' + user.photo"
                                alt="User Photo"
                                class="h-24 w-24 rounded-xl object-cover"
                            />
                            <div v-else class="h-24 w-24 rounded-xl bg-secondary flex items-center justify-center">
                                No Photo
                            </div>
                            <input
                                ref="fileInput"
                                id="photo"
                                type="file"
                                class="hidden"
                                @change="form.photo = $event.target.files[0]"
                                accept="image/*"
                            />
                            <Button variant="default" @click="triggerFileInput">Edit Photo</Button>
                        </div>
                        <InputError class="mt-2" :message="form.errors.photo" />
                    </div>

                    <!-- Name Section -->
                    <div class="grid">
                        <HeadingSmall title="Nama" ></HeadingSmall>
                        <p class="text-sm">{{ user.name }}</p>
                    </div>

                    <!-- NIDN Section -->
                    <div class="grid">
                        <HeadingSmall title="Nomor Induk" ></HeadingSmall>
                        <p class="text-sm">{{ user.nidn }}</p>
                    </div>

                    <!-- Email Section -->
                    <div class="grid gap-2">
                        <HeadingSmall title="Email" ></HeadingSmall>
                        <p class="text-sm">{{ user.email }}</p>
                    </div>

                    <!-- Department Section -->
                    <div class="grid">
                        <HeadingSmall title="Departemen" ></HeadingSmall>
                        <p class="text-sm">{{ user.department || "Tidak Teridentifikasi"}}</p>
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="text-muted-foreground -mt-4 text-sm">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>