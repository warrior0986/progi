<script>
import Results from '@/Pages/Results.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

export default {
    name: 'Budget',
    components: {
        Results,
        Head
    },
    data() {
        return {
            budget: {
                value: 0,
                maximunVehicleAmount: 0,
                fees: {
                    basic: 0,
                    special: 0,
                    association: 0,
                    storage: 0
                }
            }
        }
    },
    methods: {
        calculate() {
            axios.post(route('calculate'), {
                budget: this.budget.value
            }).then((response) => {
                this.budget.value = response.data.result.budget;
                this.budget.maximunVehicleAmount = response.data.result.maxAmount;
                this.budget.fees.basic = response.data.result.fees.basic;
                this.budget.fees.special = response.data.result.fees.special;
                this.budget.fees.association = response.data.result.fees.association;
                this.budget.fees.storage = response.data.result.fees.storage;
            })
        }
    }
}
</script>

<template>
    <Head title="Progi Bid Calculation" />
    <div class=" bg-gray-100 min-h-screen ">
        <div class="block p-10 rounded-lg shadow-2xl bg-white max-w-fit m-4">
            <div class="">
                <form @submit.prevent="submit">
                    <label for="budget">Budget</label>        
                    <input
                        id="budget"
                        type="budget"
                        class="mt-1 block w-full shadow-lg hover:border-2xl"
                        v-model="budget.value"
                        required
                        autofocus
                        @keyup="calculate"
                    />
                </form>
            </div>
            <br>
            <Results :budget="budget"/>
            <br>
            <button
                class="
                    inline-flex
                    items-center
                    px-4 py-2
                    bg-gray-800
                    border border-transparent
                    rounded-md
                    font-semibold
                    text-xs
                    text-white uppercase
                    tracking-widest
                    hover:bg-gray-700
                    focus:bg-gray-700
                    active:bg-gray-900
                    focus:outline-none
                    focus:ring-2
                    focus:ring-indigo-500
                    focus:ring-offset-2
                    transition
                    ease-in-out
                    duration-150
                "
            >
                <a :href="route('fee-configuration')">Fee Configuration</a>
            </button>
        </div>
    </div>
</template>
