<template>
    <div>
        <div>
            <h2 class="h2 justify-center flex content-center" style="font-family: 'Roboto'">Investigation Software developed by Craco</h2>
        </div>
        <div>
            <h3 class="h3 justify-center flex content-center" style="font-family: 'Roboto'">v0.8 beta production</h3>
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
