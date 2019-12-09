<template>
  <hide-box :heading="extras.strings.featured_image | cap">
    <div class="text-2xl font-bold">
      <a v-if="!imageVisible" @click.prevent="open = true" class="cursor-pointer text-green-500 underline"
        >+{{ extras.strings.set_featured_image | cap }}</a
      >
      <img
        v-show="imageVisible"
        @error="imageVisible = false"
        @load="imageVisible = true"
        :src="imageUrl"
        alt="featured image preview"
        style=" width:20rem"
      />
      <a v-if="imageVisible" @click="close" class="cursor-pointer text-red-500 underline"
        >-{{ 'Remove featured image' | cap }}</a
      >
      <word-press-media :open="open" :media-props="wpAttributes" @selection="getAttachment" />
    </div>
  </hide-box>
</template>
<script>
import HideBox from './HideBox';
import WordPressMedia from './WordPressMedia';

export default {
  components: { HideBox, WordPressMedia },
  data() {
    return {
      imageUrl: '',
      imageVisible: true,
      wpAttributes: {},
      open: false,
    };
  },
  created() {
    this.wpAttributes = {
      title: this.extras.strings.set_featured_image,
      button: {
        text: this.extras.strings.use_image,
      },
      multiple: false,
    };
  },
  methods: {
    getAttachment(attachment) {
      this.imageUrl = attachment.url;
      this.setFeaturedId(attachment.id);
      this.open = false;
    },
    setFeaturedId(id) {
      this.store.featured_id = id;
    },
    close() {
      this.imageUrl = '';
      this.imageVisible = false;
      this.setFeaturedId(undefined);
    },
  },
};
</script>
