<template>
    <tr>
        <td>
            <form-label :helpmessage="typedata.help" :id="typedata.id">
                {{typedata.label}}
            </form-label>
        </td>
        <td>
            <select @change="$emit('change',$event.target.value)" :value="value" :name="typedata.id" :id="typedata.id">
                <option v-for="option in typedata.options">
                    {{option}}
                </option>
            </select>
        </td>
    </tr>
</template>
<script>
    import HelpBox from "./HelpBox";
    import FormLabel from "./FormLabel";

    export default {
        props: ['typedata', 'value'],
        components: {FormLabel, HelpBox},
        model: {
            prop: 'value',
            event: 'change'
        }
    }
</script>