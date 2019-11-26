<template>
    <select v-if="isElementType('select')">
        <option v-for="option in data.options">{{option}}</option>
    </select>
    <a class="bg-gray-400 p-2 cursor-pointer border-b-2 border-r-2 border-gray-500" v-else-if="isElementType('button')">
        {{data.label}}
    </a>
    <input v-else-if="isElementType('text')">
    <input v-else-if="isElementType('colorpicker')" type="color">
    <input v-else-if="isElementType('date')" type="date">
</template>
<script>
    export default {
        props: ['filterdata', 'data'],
        methods: {
            isElementType(el) {
               if(!this.filterdata[el].push){
                   this.filterdata[el] = [this.filterdata[el]];
               }

               const result = this.filterdata[el].filter(rule => {
                   if(this.data.type.match(rule) !== null){
                       return rule;
                   }
               })
                return result.length > 0;
            }
        }
    }

</script>