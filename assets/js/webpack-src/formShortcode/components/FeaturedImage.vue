<template>
  <hide-box :force-show="imageVisible" :heading="extras.strings.featured_image | cap">
    <div>
      <a v-if="!imageVisible" @click.prevent="open = true" class="wpcd-fs-pointer wpcd-fs-bold"
        >+{{ extras.strings.set_featured_image | cap }}</a
      >
      <div>
        <img
          v-show="imageVisible"
          @error="imageVisible = false"
          @load="imageVisible = true"
          :src="imageUrl"
          alt="featured image preview"
          style=" width:100px"
        />
      </div>
      <div>
        <a v-if="imageVisible" @click="close" class="wpcd-fs-pointer wpcd-fs-bold wpcd-fs-text-red-500"
          >-{{ 'Remove featured image' | cap }}</a
        >
      </div>
      <word-press-media :open="open" :media-props="wpAttributes" @selection="getAttachment" />
    </div>
  </hide-box>
</template>
<script>
import HideBox from './HideBox';
import WordPressMedia from './WordPressMedia';

export default {
  components: { HideBox, WordPressMedia },
  props: ['featuredUrl'],
  data() {
    return {
      imageUrl: this.featuredUrl,
      imageVisible: false,
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
      this.$set(this.store, 'featured_url', this.imageUrl);
      this.setFeaturedId(attachment.id);
      this.open = false;
    },
    setFeaturedId(id) {
      this.store.featured_id = id;
    },
    close() {
      const defaultUrl = this.extras.options.default_featured_url;
      this.store.featured_url = defaultUrl;
      this.imageUrl = '';
      this.imageVisible = false;
      this.setFeaturedId('remove');
    },
  },
};
</script>
