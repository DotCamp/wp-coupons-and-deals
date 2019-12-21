<template>
  <div class="wpcd-fs-flex wpcd-fs-justify-center wpcd-fs-items-center wpcd-fs-h-full-important">
    <popup :message="extras.strings.shortcode_copy | cap" :show="show" class="wpcd-fs-bold" />
    <button @click="copy">
      Copy
    </button>
  </div>
</template>
<script>
import Popup from './Popup';

export default {
  props: ['id'],
  components: { Popup },
  data() {
    return {
      show: false,
      showPeriod: 1500,
    };
  },
  methods: {
    copy() {
      const dText = document.createElement('input');
      dText.type = 'text';
      dText.style = 'display:fixed; top:0; left:0';
      dText.value = this.id;
      document.body.appendChild(dText);

      dText.select();

      document.execCommand('copy');
      document.body.removeChild(dText);
      this.showPop();
    },
    showPop() {
      this.show = true;

      setTimeout(() => {
        this.show = false;
      }, this.showPeriod);
    },
  },
};
</script>
