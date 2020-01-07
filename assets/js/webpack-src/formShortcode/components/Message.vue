<template>
  <transition name="wpcd-fs-transition-basic-fade">
    <div
      v-if="visible"
      class="wpcd-fs-p-1 wpcd-fs-dynamic-border wpcd-fs-bg-gray-100 wpcd-fs-rounded wpcd-fs-m-2 wpcd-fs-shadow wpcd-fs-message-wrapper wpcd-fs-relative wpcd-fs-overflow-hidden wpcd-form-shortcode-generic-transition"
    >
      <div class="wpcd-fs-message-indexer" :class="typeClass"></div>
      <div
        class="wpcd-fs-message-holder wpcd-fs-flex wpcd-fs-w-full-important wpcd-fs-h-full-important wpcd-fs-items-center wpcd-fs-space-between"
      >
        <div>
          {{ message }}
        </div>
        <div class=" wpcd-fs-pointer wpcd-fs-message-close-btn" :class="typeClass" @click="close"></div>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  props: {
    type: {
      type: String,
      default: 'all',
    },
  },
  data() {
    return {
      visible: false,
      lastShown: 0,
    };
  },
  mounted() {
    this.setVisibility();
  },
  computed: {
    typeClass() {
      return `wpcd-fs-message-${this.app.message.type}`;
    },
    message() {
      return this.app.message.text;
    },
  },
  methods: {
    isOurType() {
      return this.type === 'all' || this.app.message.type === this.type;
    },
    setVisibility() {
      const isNewMessage = this.app.message.time > this.lastShown;
      const visible = isNewMessage && this.isOurType();
      this.visible = visible;
      if (visible) {
        this.lastShown = this.app.message.time;
      }
    },
    close() {
      this.app.message.time = 0;
    },
  },
  watch: {
    'app.message.time': {
      handler() {
        this.setVisibility();
      },
    },
  },
  beforeDestroy() {
    if (this.isOurType()) {
      this.app.message.time = 0;
    }
  },
};
</script>
