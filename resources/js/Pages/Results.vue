<template>
    <table class="table-auto tg">
    <thead>
    <tr>
        <th class="tg-73oq" rowspan="2">Budget</th>
        <th class="tg-73oq" rowspan="2">Maximum vehicle amount</th>
        <th class="tg-73oq" colspan="4">Fees</th>
    </tr>
    <tr>
        <th class="tg-73oq">Basic</th>
        <th class="tg-73oq">Special</th>
        <th class="tg-73oq">Association</th>
        <th class="tg-73oq">Storage</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="tg-3z1b">{{budget.value}}</td>
        <td class="tg-3z1b">{{budget.maximunVehicleAmount}}</td>
        <td class="tg-3z1b">{{budget.fees.basic}}</td>
        <td class="tg-3z1b">{{budget.fees.special}}</td>
        <td class="tg-3z1b">{{budget.fees.association}}</td>
        <td class="tg-3z1b">{{budget.fees.storage}}</td>
    </tr>
    </tbody>
    </table>
</template>
<script>

export default {
    name: 'Results',
    props: {
        budget: {}
    }
}
</script>

<style scoped>
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-3z1b{border-color:#000000;text-align:right;vertical-align:top}
.tg .tg-73oq{border-color:#000000;text-align:left;vertical-align:top}
</style>