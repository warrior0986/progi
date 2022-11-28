<template>
    <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md">
        <template v-if="fees.normalFees">
            <template v-for="fee in fees.normalFees" :key="fee.id">
                <label class="block uppercase">{{fee.name}}</label>
                <div class="form-group mb-6">
                    <label for="value" class="form-label inline-block mb-2 text-gray-700">Value</label>
                    <input type="number" class="form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" v-model="fee.value">

                    <label for="type" class="form-label inline-block mb-2 text-gray-700">Type</label>
                    <select class="form-select form-control appearance-none
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding bg-no-repeat
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        v-model="fee.type">
                            <option value="fixed">Fixed</option>
                            <option value="percent">Percent</option>
                            <option value="assoc">Association</option>
                        </select>

                    <label for="min" class="form-label inline-block mb-2 text-gray-700">Min</label>
                    <input type="number" class="form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" v-model="fee.min">

                    <label for="max" class="form-label inline-block mb-2 text-gray-700">Max</label>
                    <input type="number" class="form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" v-model="fee.max">
                </div>
            </template>
        </template>
        <button class="
        px-6
        py-2.5
        bg-blue-600
        text-white
        font-medium
        text-xs
        leading-tight
        uppercase
        rounded
        shadow-md
        hover:bg-blue-700 hover:shadow-lg
        focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
        active:bg-blue-800 active:shadow-lg
        transition
        duration-150
        ease-in-out"
        @click="submit"
        >Submit</button>
        <button class="
        px-6
        py-2.5
        bg-blue-600
        text-white
        font-medium
        text-xs
        leading-tight
        uppercase
        rounded
        shadow-md
        hover:bg-blue-700 hover:shadow-lg
        focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
        active:bg-blue-800 active:shadow-lg
        transition
        duration-150
        ease-in-out"
        >
        <a :href="route('index')">Go Back</a></button>
        
      </div>
</template>

<script>
export default {
    name: 'Fees Configuration',
    data() {
        return {
            fees: {
                normalFees: {},
                assocFees: {}
            }
        }
        
    },
    mounted() {
        axios.get(route('getConfig'))
            .then((response) => {
                this.fees.normalFees = response.data.normalFees;
                this.fees.assocFees = response.data.assocFees;
            });
    },
    methods: {
        submit() {
            axios.post(route('update'), {
                fees: this.fees
            }).then((response) => {
                window.location.href = route('index');
            })
        }
    }
}

</script>