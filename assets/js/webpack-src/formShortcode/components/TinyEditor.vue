<template>
  <div>
    <div id="wpcd-fs-tiny-editor"></div>
  </div>
</template>
<script>
export default {
  props: ['storebind'],
  mounted() {
    setTimeout(() => {
      tinyMCE.init({
        selector: '#wpcd-fs-tiny-editor',
        setup: editor => {
          editor.on('input', () => {
            const content = editor.getContent();
            this.$set(this.store, this.storebind, content);
          });
        },
      });
    }, 1000);
  },
};
</script>
