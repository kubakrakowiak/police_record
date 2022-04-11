<template>
<!--    <div class="bg-white w-1/3 rounded-xl shadow-lg flex items-center justify-around"></div>-->
        <div>
            <div>
                <h2 class="h2 justify-center flex content-center" style="font-family: 'Roboto'">Crime Software developed by Craco</h2>
            </div>
            <div>
                <h3 class="h3 justify-center flex content-center" style="font-family: 'Roboto'">v0.9 beta production</h3>
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
