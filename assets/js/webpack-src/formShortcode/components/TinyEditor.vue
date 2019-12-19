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
        menubar: '',
        toolbar: 'bold italic underline bullist numlist alignleft aligncenter alignright link unlink',
        setup: editor => {
          editor.on('init', () => {
            if (this.store[this.storebind]) {
              editor.setContent(this.store[this.storebind]);
            }
          });
          editor.on('input', () => {
            const content = editor.getContent();
            this.$set(this.store, this.storebind, content);
          });
          editor.on('Change', () => {
            const content = editor.getContent();
            this.$set(this.store, this.storebind, content);
          });
        },
      });
    }, 100);
  },
  beforeDestroy() {
    if (tinyMCE.activeEditor !== null) {
      tinyMCE.activeEditor.remove();
    }
  },
};
</script>
