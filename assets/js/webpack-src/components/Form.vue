<template>
    <div class="text-gray-700">
        <div class="italic flex items-center justify-center text-gray-500 font-mono w-full bg-gray-200 mb-16 shadow border-4 border-dashed border-gray-400 h-40 text-md">
            coupon live preview
        </div>
        <div class="flex items-center flex-col bg-gray-100 border-t-4 border-l-4 shadow-lg rounded p-4">
            <div class="text-6xl font-bold bg-gray-200 p-2 rounded shadow">Coupon Submit Form</div>
            <div class="flex items-center flex-col m-4">
                <div class="m-2 text-sm p-2 bg-gray-200 border border-gray" v-if="showSampleField">{{fields[0]}}</div>
                <button @click="showSampleField=!showSampleField" class="text-sm p-2 rounded-full text-white">
                    {{showSampleField?'hide':'show'}} sample field data
                </button>
            </div>
            <form>
                <table class="border-collapse border-2 border-dashed">
                    <tr v-for="field in fields">
                        <td>
                            <label :id="field.id" :name="field.id">
                                {{field.label}}
                                <span :title="field.help"
                                      class="ml-4 bg-gray-400 rounded-full p-2 text-white hover:bg-white hover:text-gray-400">?</span>
                            </label>
                        </td>
                        <td class="text-right">
                            <select :name="field.name" class="p-2 rounded border-4 border-gray-400 bg-gray-200"
                                    v-if="field.type==='select'">
                                <option v-for="option in field.options">
                                    {{option}}
                                </option>
                            </select>
                            <input :name="field.name" :type="field.type" v-else>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['message', 'fields'],
        data() {
            return {
                showSampleField: false
            };
        }
    }
</script>