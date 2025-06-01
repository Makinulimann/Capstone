<script setup lang="ts">
<<<<<<< HEAD
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';
=======
import Heading from '@/components/Heading.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
>>>>>>> Back-End

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

<<<<<<< HEAD
defineProps<Props>();
=======
const props = defineProps<Props>();
>>>>>>> Back-End

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

<<<<<<< HEAD
const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};
=======
const form = useForm(
    {
        photo: null as File | null,
    },
    {
        transform: (data) => {
            const formData = new FormData();
            if (data.photo) {
                formData.append('photo', data.photo);
            }
            return formData;
        },
    },
);

// Reference to the file input for triggering it via the button
const fileInput = ref<HTMLInputElement | null>(null);

// Preview URL for the selected photo
const photoPreview = ref<string | null>(null);

const submit = () => {
    form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('photo');
            photoPreview.value = null;
            // Reset file input
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
        onError: (errors) => {
            console.log('Upload errors:', errors);
        },
        onFinish: () => {
            console.log('Upload finished');
        },
    });
};

const triggerFileInput = () => {
    if (fileInput.value) {
        fileInput.value.click();
    }
};

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.photo = file;

        // Create preview URL
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    } else {
        form.photo = null;
        photoPreview.value = null;
    }
};

// Computed property to determine which image to show
const displayPhoto = computed(() => {
    if (photoPreview.value) {
        return photoPreview.value;
    }
    if (user.photo) {
        return '/storage/' + user.photo;
    }
    return null;
});

const removePhoto = () => {
    form.photo = null;
    photoPreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};
>>>>>>> Back-End
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
<<<<<<< HEAD
                <HeadingSmall title="Profile information" description="Update your name and email address" />

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
=======
                <Heading title="Profil" description="Informasi Profil Pengguna" />

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Photo Section -->
                    <div class="grid gap-2">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img
                                    v-if="displayPhoto"
                                    :src="displayPhoto"
                                    alt="User Photo"
                                    class="h-24 w-24 rounded-xl border-2 border-gray-200 object-cover"
                                />
                                <div
                                    v-else
                                    class="bg-secondary flex h-24 w-24 items-center justify-center rounded-xl border-2 border-dashed border-gray-300"
                                >
                                    <span class="text-muted-foreground text-center text-xs">No Photo</span>
                                </div>

                                <!-- Loading indicator -->
                                <div
                                    v-if="form.processing"
                                    class="bg-opacity-50 absolute inset-0 flex items-center justify-center rounded-xl bg-black"
                                >
                                    <div class="h-6 w-6 animate-spin rounded-full border-b-2 border-white"></div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <input
                                    ref="fileInput"
                                    id="photo"
                                    type="file"
                                    class="hidden"
                                    @change="handleFileChange"
                                    accept="image/jpeg,image/png,image/jpg,image/gif"
                                />
                                <Button type="button" variant="default" @click="triggerFileInput" :disabled="form.processing">
                                    {{ displayPhoto ? 'Ganti Foto' : 'Pilih Foto' }}
                                </Button>

                                <Button
                                    v-if="form.photo || photoPreview"
                                    type="button"
                                    variant="outline"
                                    @click="removePhoto"
                                    :disabled="form.processing"
                                    class="text-red-600 hover:text-red-700"
                                >
                                    Hapus Foto
                                </Button>
                            </div>
                        </div>

                        <p class="text-muted-foreground text-xs">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>

                        <InputError class="mt-2" :message="form.errors.photo" />
                    </div>

                    <!-- Name Section -->
                    <div class="grid">
                        <HeadingSmall title="Nama" />
                        <p class="text-sm">{{ user.name }}</p>
                    </div>

                    <!-- NIDN Section -->
                    <div class="grid">
                        <HeadingSmall title="Nomor Induk" />
                        <p class="text-sm">{{ user.nidn }}</p>
                    </div>

                    <!-- Email Section -->
                    <div class="grid gap-2">
                        <HeadingSmall title="Email" />
                        <p class="text-sm">{{ user.email }}</p>
                    </div>

                    <!-- Department Section -->
                    <div class="grid">
                        <HeadingSmall title="Departemen" />
                        <p class="text-sm">{{ user.department || 'Tidak Teridentifikasi' }}</p>
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="text-muted-foreground -mt-4 text-sm">
>>>>>>> Back-End
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
<<<<<<< HEAD
                        <Button :disabled="form.processing">Save</Button>
=======
                        <Button type="submit" :disabled="form.processing || !form.photo" class="min-w-[80px]">
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan</span>
                        </Button>
>>>>>>> Back-End

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
<<<<<<< HEAD
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
=======
                            <p v-show="form.recentlySuccessful" class="text-sm text-green-600">Tersimpan.</p>
>>>>>>> Back-End
                        </Transition>
                    </div>
                </form>
            </div>
<<<<<<< HEAD

            <DeleteUser />
=======
>>>>>>> Back-End
        </SettingsLayout>
    </AppLayout>
</template>
