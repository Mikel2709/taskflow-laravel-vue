<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

defineProps({
    tasks: Array, 
}); 

const form = useForm({
    title: '',
    description: '',
    status: 'pending',
    priority: 'medium', 
    due_date: '',
});

const submit = () => {
    form.post(route('tasks.store'),{
        onSuccess: () => form.reset(),
    });
};

const markAsCompleted = (task) => {
    router.patch(route('tasks.update', task.id), {
        status: 'completed',
        },{
            preserveScroll: true
        });
};

const deleteTask = (task) => {
    router.delete(route('tasks.destroy', task.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                TaskFlow - Task Manager
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
                <div class="mb-6 rounded bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-semibold">Create task</h3>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">
                                Title<span class="text-red-600">*</span>
                            </label>
                            <input
                                v-model="form.title"
                                type="text"
                                required
                                class="mt-1 w-full rounded border-gray-300"
                            />
                            <p v-if="form.errors.title" class="text-sm text-red-600">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">
                                Description<span class="text-red-600">*</span>
                            </label>
                            <textarea
                                v-model="form.description"
                                required
                                class="mt-1 w-full rounded border-gray-300"
                            ></textarea>
                             <p v-if="form.errors.description" class="text-sm text-red-600">
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium">
                                    Status<span class="text-red-600">*</span>
                                </label>
                                <select 
                                    v-model="form.status" 
                                    class="mt-1 w-full rounded border-gray-300" 
                                    required
                                >
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">
                                    Priority <span class="text-red-600">*</span>
                                </label>
                                <select v-model="form.priority" class="mt-1 w-full rounded border-gray-300" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">
                                    Due date<span class="text-red-600">*</span>
                                </label>
                                <input
                                    v-model="form.due_date"
                                    type="date"
                                    required
                                    class="mt-1 w-full rounded border-gray-300"
                                />
                                <p v-if="form.errors.due_date" class="text-sm text-red-600">
                                    {{ form.errors.due_date }}
                                </p>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                            :disabled="form.processing"
                        >
                            Save task
                        </button>
                    </form>
                </div>

                <div class="rounded bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-semibold">My tasks</h3>

                    <div v-if="tasks.length === 0" class="text-gray-500">
                        No tasks yet.
                    </div>

                    <div v-else class="space-y-3">
                        <div
                            v-for="task in tasks"
                            :key="task.id"
                            class="rounded border p-4"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="font-semibold">{{ task.title }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ task.description }}
                                    </p>

                                    <div class="mt-2 flex gap-2 text-xs">
                                        <span class="rounded bg-gray-100 px-2 py-1">
                                            {{ task.status }}
                                        </span>
                                        <span class="rounded bg-gray-100 px-2 py-1">
                                            {{ task.priority }}
                                        </span>
                                        <span v-if="task.due_date" class="rounded bg-gray-100 px-2 py-1">
                                            Due: {{ task.due_date }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <button
                                        v-if="task.status !== 'completed'"
                                        @click="markAsCompleted(task)"
                                        class="rounded bg-green-600 px-3 py-1 text-sm text-white hover:bg-green-700"
                                    >
                                        Complete
                                    </button>

                                    <button
                                        @click="deleteTask(task)"
                                        class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>