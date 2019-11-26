<template>
                <span :title="message"
                      class="ml-4 bg-gray-400 rounded-full px-3 float-right text-white hover:bg-white hover:text-gray-400">
                    <slot></slot>
                </span>
</template>
<script>
    export default {
        props: ['message'],
}
</script>