<template>
  <span />
</template>
<script>
export default {
  props: ['open', 'media-props'],
  data() {
    return {
      frame: null,
    };
  },
  watch: {
    open(n) {
      if (n) {
        if (this.frame) {
          this.frame.open();
        } else {
          this.frame = wp.media(this.mediaProps);

          this.frame.on('select', () => {
            const attachment = this.frame
              .state()
              .get('selection')
              .first()
              .toJSON();

            this.$emit('selection', attachment);
          });

          this.frame.open();
        }
      }
    },
  },
};
</script>
