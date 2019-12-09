<template>
  <div class="bg-white mt-4 mb-4 shadow">
    <div
      @click="showChild = !showChild"
      class="wpcd-form-shortcode-generic-transition hover:bg-gray-200 cursor-pointer text-2xl font-bold border border-l-0 border-r-0 border-b-2 p-2"
    >
      {{ heading }}
      <div class="wpcd-form-shortcode-toggle-button h-4 float-right" :aria-expanded="JSON.stringify(showChild)">
        <span class="wpcd-form-shortcode-toggle-indicator" />
      </div>
    </div>
    <div v-show="showChild" class="p-2 form-shortcode-row">
      <slot />
    </div>
  </div>
</template>
<script>
export default {
  props: ['heading'],
  data() {
    return {
      showChild: false,
    };
  },
};
</script>
