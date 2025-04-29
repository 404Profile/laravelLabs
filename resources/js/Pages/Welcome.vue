<script setup>
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';
import Pagination from "@/Components/Custom/Pagination.vue";
import {ref} from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    posts: Object,
})

const form = useForm({
    body: '',
})

const currentPost = ref(null)
const isOpen = ref(false)

const page = usePage();

const closeModal = () => {
    isOpen.value = false
    currentPost.value = null
}

const openModal = (el) => {
    currentPost.value = el;
    isOpen.value = true
}

const createComment = (id) => {
    router.post(route('postComment.store'), {
        postId: id,
        body: form.body,
    }, {
        onSuccess: () => {
            const newComment = {
                body: form.body,
                user: {
                    name: page.props.auth.user.name
                }
            };

            currentPost.value.comments.push(newComment);

            form.reset('body');
        }
    })
}
</script>

<template>
    <Head title="Welcome" />

    <div class="w-full flex justify-center">
        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Dashboard
        </Link>

        <template v-else>
            <Link
                :href="route('login')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Log in
            </Link>

            <Link
                :href="route('register')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Register
            </Link>
        </template>

        <Link
            :href="route('guest-book.index')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Guest Book
        </Link>
    </div>

    <div class="w-full flex justify-center">
        <h1 class="text-2xl text-semibold">My Blog</h1>
    </div>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-6 mx-auto">
            <div class="flex flex-wrap -m-4">
                <template v-for="(post, index) in posts.data" :key="index">
                    <div @click="openModal(post)" class="p-4 md:w-1/3 cursor-pointer">
                        <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center"
                                 :src="'storage/' + post.photo_path" alt="404">

                            <div class="p-6">
                                <h1 class="title-font text-lg font-medium text-gray-900 mb-3">
                                    {{ post.title }}
                                </h1>
                                <div>
                                    Author: {{ post.user.name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex justify-center w-full">
                    <pagination :links="posts.links" />
                </div>

            </div>
        </div>
    </section>

    <template v-if="isOpen">
        <TransitionRoot :show="isOpen" appear as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900"
                                >
                                    {{ currentPost.title }}
                                </DialogTitle>

                                <div>
                                    <img class="lg:h-72 md:h-52 w-full object-cover object-center"
                                         :src="'storage/' + currentPost.photo_path" alt="404">
                                </div>

                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        {{ currentPost.body }}
                                    </p>
                                </div>

                                <div v-if="$page.props.auth.user" class="my-4">
                                    <p>Write Comment on this post:</p>
                                    <div class="col-span-6 sm:col-span-4">
                                        <InputLabel for="email" value="Body" />
                                        <textarea
                                            id="body"
                                            v-model="form.body"
                                            type="text"
                                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                                            required
                                            autofocus
                                            autocomplete="body"
                                        />
                                        <InputError class="mt-2" :message="form.errors.body" />
                                    </div>

                                    <div class="flex justify-end py-2">
                                        <button @click="createComment(currentPost.id)" class="relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg gap-1.5 px-3 py-1.5 text-sm inline-grid shadow-sm bg-amber-600 text-white hover:bg-amber-500 focus-visible:ring-amber-500/50 dark:bg-amber-500 dark:hover:bg-amber-400 dark:focus-visible:ring-amber-400/50">
                                            Write Comment
                                        </button>
                                    </div>
                                </div>

                                <div class="py-4">
                                    <div v-for="(comment, index) in currentPost.comments" :key="index">
                                        <div class="border-b border-gray-300">
                                            <div>
                                                Author: {{ comment.user.name }}
                                            </div>
                                            <div>
                                                Text: "{{ comment.body }}"
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="closeModal"
                                    >
                                        Close
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </template>

</template>
