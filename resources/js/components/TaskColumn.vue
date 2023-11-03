<template>
<div class="w-[300px] rounded-lg shadow-lg"
       :class="{
         'bg-blue-500': kanban.phases[props.phase_id].status === 1,
         'bg-sky-950': kanban.phases[props.phase_id].status !== 1
       }">
       
    <div class="p-4 max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-3">
            <div class="flex flex-row items-center gap-2">            
                <h2 class="text-lg font-black text-zinc-100">{{ kanban.phases[props.phase_id].name }}</h2>
                <p class="px-2 pt-0.5 text-sm font-black border border-white rounded-full text-zinc-100 text-center">
                    {{ kanban.phases[props.phase_id].task_count > 0 ? kanban.phases[props.phase_id].task_count : 0 }}
                </p>
            </div>

            <TrashIcon 
                @click="deleteCards(kanban.phases[props.phase_id])"
                class="w-6 h-6 text-white hover:cursor-pointer" 
                aria-hidden="true" />
        </div>
        <task-card v-if="kanban.phases[props.phase_id].tasks.length > 0" v-for="task in kanban.phases[props.phase_id].tasks" :task="task" />
        
        <!-- A card to create a new task -->
        <div class="relative flex items-center justify-between w-full p-3 text-gray-900 bg-white rounded-lg shadow-md hover:cursor-pointer"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="w-6 h-6" aria-hidden="true" />
        </div>

    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'

const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

const deleteCards = async (id) => {
    try {
        const response = await axios.delete('/api/phases/' + props.phase_id);
        kanban.selectedTaskEdit = null;
        await refreshTasks();
    } catch (error) {
        console.error('There was an error deleting the task!', error);
    }
}

const refreshTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        const originalTasks = response.data;
        kanban.phases = originalTasks.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}


</script>