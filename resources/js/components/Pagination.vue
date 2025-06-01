<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    pagination?: {
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
}>();

const emit = defineEmits(['page-changed']);

const pagination = computed(() => props.pagination || {
    current_page: 1,
    last_page: 1,
    from: 0,
    to: 0,
    total: 0,
});

const changePage = (page: number) => {
    if (page > 0 && page <= pagination.value.last_page) {
        emit('page-changed', page);
    }
};

const visiblePages = computed(() => {
    const pages = [];
    const start = Math.max(1, pagination.value.current_page - 2);
    const end = Math.min(pagination.value.last_page, pagination.value.current_page + 2);
    for (let page = start; page <= end; page++) {
        pages.push(page);
    }
    return pages;
});
</script>

<template>
    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4 bg-white dark:bg-gray-800 px-6 py-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Menampilkan <span class="font-semibold">{{ pagination.from }}</span> sampai 
            <span class="font-semibold">{{ pagination.to }}</span> dari 
            <span class="font-semibold">{{ pagination.total }}</span> hasil
        </div>
        <div class="flex items-center space-x-2">
            <Button
                variant="outline"
                size="sm"
                :disabled="pagination.current_page === 1"
                @click="changePage(pagination.current_page - 1)"
                class="flex items-center space-x-1"
            >
                <ChevronLeft class="w-4 h-4" />
                <span>Previous</span>
            </Button>

            <div class="flex items-center space-x-1">
                <Button
                    v-for="page in visiblePages"
                    :key="page"
                    variant="outline"
                    size="sm"
                    :class="{ 'bg-purple-600 border-purple-600 text-white hover:bg-purple-700': pagination.current_page === page, 'hover:bg-gray-50 dark:hover:bg-gray-700': pagination.current_page !== page }"
                    @click="changePage(page)"
                >
                    {{ page }}
                </Button>
                <span v-if="pagination.last_page > 5 && visiblePages[visiblePages.length - 1] < pagination.last_page" class="px-2 text-gray-500">...</span>
            </div>

            <Button
                variant="outline"
                size="sm"
                :disabled="pagination.current_page === pagination.last_page"
                @click="changePage(pagination.current_page + 1)"
                class="flex items-center space-x-1"
            >
                <span>Next</span>
                <ChevronRight class="w-4 h-4" />
            </Button>
        </div>
    </div>
</template>