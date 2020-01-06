<template>
  <transition name="wpcd-fs-transition-basic-fade">
    <div
      v-if="visible"
      class="wpcd-fs-p-4 wpcd-fs-bg-gray-100 wpcd-fs-rounded wpcd-fs-m-2 wpcd-fs-shadow wpcd-fs-message-wrapper wpcd-fs-relative wpcd-fs-overflow-hidden wpcd-form-shortcode-generic-transition"
    >
      <div class="wpcd-fs-message-indexer" :class="typeClass"></div>
      <div class="wpcd-fs-message-holder wpcd-fs-inline-block">{{ message }}</div>
      <div class="wpcd-fs-inline-block wpcd-fs-float-right wpcd-fs-pointer" @click="close">
        <span
          class="dashicons dashicons-dismiss"
          :class="typeClass"
          style="background-color: transparent  !important"
        />
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  props: ['type'],
  data() {
    return {
      visible: true,
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
    setVisibility() {
      const isNewMessage = this.app.message.time > this.lastShown;
      this.visible = isNewMessage;
      if (isNewMessage) {
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
    this.app.message.time = 0;
  },
};
</script>
