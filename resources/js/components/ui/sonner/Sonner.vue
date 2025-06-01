<script lang="ts" setup>
import { Toaster as Sonner, type ToasterProps } from 'vue-sonner'
import { CheckCircle2, AlertTriangle } from 'lucide-vue-next'
import 'vue-sonner/style.css'

const props = defineProps<ToasterProps>()

// Define default props to ensure richColors is true if not provided
const mergedProps = {
  ...props,
  richColors: props.richColors ?? true, // Fallback to true if not specified
}
</script>

<template>
  <Sonner
    class="toaster"
    position="top-right"
    v-bind="mergedProps"
  >
    <template #default="{ toasts }">
      <transition-group name="toast" tag="div">
        <div v-for="toast in toasts" :key="toast.id" class="toast-card">
          <div class="toast-content" :class="toast.type">
            <component :is="toast.type === 'success' ? CheckCircle2 : AlertTriangle" class="toast-icon" />
            <span class="toast-message">{{ toast.description }}</span>
          </div>
        </div>
      </transition-group>
    </template>
  </Sonner>
</template>

<style scoped>
.toaster {
  --toast-width: 320px;
  --toast-padding: 12px 16px;
  --toast-border-radius: 10px;
  --toast-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  --transition-duration: 0.3s;
}

.toast-enter-active, .toast-leave-active {
  transition: all var(--transition-duration) ease;
}

.toast-enter-from, .toast-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

.toast-card {
  margin: 8px;
  width: var(--toast-width);
}

.toast-content {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: var(--toast-padding);
  border-radius: var(--toast-border-radius);
  box-shadow: var(--toast-shadow);
  color: white;
  font-size: 14px;
  line-height: 1.5;
}

.toast-content.success {
  background: linear-gradient(135deg, #34D399 0%, #10B981 100%);
}

.toast-content.error {
  background: linear-gradient(135deg, #F87171 0%, #EF4444 100%);
}

.toast-icon {
  width: 20px;
  height: 20px;
}

.toast-message {
  flex-grow: 1;
  word-wrap: break-word;
}

:deep(.sonner) {
  z-index: 9999;
}
</style>