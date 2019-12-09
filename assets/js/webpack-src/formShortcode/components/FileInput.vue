<template>
  <div>
    <a class="bg-gray-400 p-2 cursor-pointer border-b-2 border-r-2 border-gray-500" @click.prevent="open = true"
      >
      <slot/></a
    >
    <word-press-media @selection="imageSelected" :open="open"></word-press-media>
  </div>
</template>
<script>
import WordPressMedia from './WordPressMedia';

export default {
  components: { WordPressMedia },
  props: ['preview_id'],
  data() {
    return {
      open: false,
    };
  },
  methods: {
    imageSelected(att) {
      this.$set(this.store, this.preview_id, att.url);
      this.$set(this.store, 'coupon-attachment-id', att.id);
      this.open = false;
    },
  },
};
</script>
