<template>
    <div class="col-4">
        <LicenseForm></LicenseForm>
    </div>
</template>

<script>
import { HashLoader } from '@saeris/vue-spinners'
import LicenseForm from "../components/LicenseForm";

export default {
    data() {
        return {
            isLoading: false,
        }
    },

    components: {
        HashLoader,
        LicenseForm
    },
}
</script>
