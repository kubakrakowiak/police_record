<template>
    <div class="card">
        <div class="container m-3">
            <h1 class="text-2xl font-bold mb-8">Quick license
            </h1>
            <form id="form">
                <div class="relative z-0 w-full mb-5">
                    <input
                        type="text"
                        name="name"
                        placeholder=" "
                        required
                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                    />
                    <label for="name" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Investigation name</label>
                    <span class="text-sm text-red-600 hidden">Name is required</span>
                </div>
<!--                <div>-->
<!--                    <label class="typo__label">Type</label>-->
<!--                    <multiselect v-model="form.type.value" deselect-label="Can't remove this value" track-by="name" label="name" placeholder="Select one" :options="form.type.options" :searchable="false" :allow-empty="false">-->
<!--                        <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.name }}</strong></template>-->
<!--                    </multiselect>-->
<!--                    <pre class="language-json"><code>{{ value  }}</code></pre>-->
<!--                    <span class="text-sm text-red-600 hidden">ź</span>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <label class="typo__label">Assigned Policemans</label>-->
<!--                    <multiselect v-model="form.policemans.value" :options="form.policemans.options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick Policemans" label="name" track-by="name" :preselect-first="true">-->
<!--                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>-->
<!--                    </multiselect>-->
<!--                    <pre class="language-json"><code>{{ value  }}</code></pre>-->
<!--                </div>todo load data to form from api and uncomment it -->
            </form>
        </div>
    </div>
</template>

<script>
import { Multiselect } from 'vue-multiselect';


export default {
    name: "LicenseForm",
    components: {
        Multiselect
    }
}
</script>


