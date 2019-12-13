<template>
  <div>
    <input type="submit" @click.prevent="open = true" :value="text" />
    <word-press-media @selection="imageSelected" :open="open"></word-press-media>
  </div>
</template>
<script>
import WordPressMedia from './WordPressMedia';

export default {
  components: { WordPressMedia },
  props: ['preview_id', 'text'],
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
