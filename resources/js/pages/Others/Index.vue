<template>
    <div class="bg-white w-1/3 rounded-xl shadow-lg flex items-center justify-around">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800">9.7k</h1>
            <span class="text-gray-500">Kids</span>
        </div>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'

export default {
    data() {
        return {
            isLoading: false,
        }
    },

    components: {
        HashLoader,
    },
}
</script>
