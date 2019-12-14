<template>
  <tr @mouseover="mouseOver(true)" @mouseout="mouseOver(false)">
    <td>
      <div class="wpcd-fs-bold">
        <span class="wpcd-fs-text-blue-500">{{ post_title }}</span>
        <span>{{ post_status === 'publish' ? '' : ('| ' + post_status) | cap }} </span>
      </div>
      <div :style="{ visibility: hover ? 'visible' : 'hidden' }" class="wpcd-fs-text-sm">
        <a class="wpcd-fs-pointer wpcd-fs-text-blue-500">Edit</a> |
        <a class="wpcd-fs-pointer wpcd-fs-text-red-500">Thrash</a>
      </div>
    </td>
    <td>
      {{ coupon_type }}
    </td>
    <td>{{ ID }}</td>
  </tr>
</template>
<script>
export default {
  props: ['post_title', 'post_status', 'coupon_type', 'ID'],
  data() {
    return {
      hover: false,
    };
  },
  methods: {
    mouseOver(status) {
      this.hover = status;
    },
  },
};
</script>
