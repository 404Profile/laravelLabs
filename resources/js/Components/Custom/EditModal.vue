<script setup>
import { computed, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    onUpdate: {
        type: Function,
        required: true,
    },
});

const emit = defineEmits(['update:show']);

const close = () => {
    emit('update:show', false);
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

watch(() => props.show, (value) => {
    if (value) {
        document.body.addEventListener('keydown', closeOnEscape);
    } else {
        document.body.removeEventListener('keydown', closeOnEscape);
    }
}, { immediate: true });

const maxWidthClass = computed(() => {
    return {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="p-6">
            <div class="text-lg font-medium text-gray-900">
                <slot name="title">
                    Edit
                </slot>
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <slot name="content" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="close">
                    Cancel
                </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="onUpdate"
                >
                    Update
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
