<template>
  <th @mouseover="show = true" @mouseout="show = false" @click="colClick" class="wpcd-form-shortcode-generic-transition wpcd-fs-table-header wpcd-fs-pointer">
    {{ heading | cap }}
    <span
      :aria-expanded="JSON.stringify(expanded)"
      :style="{ visibility: show ? 'visible' : 'hidden' }"
      class="wpcd-fs-float-right wpcd-fs-toggle-button"
    >
      <span class="wpcd-fs-toggle-indicator" />
    </span>
  </th>
</template>
<script>
export default {
  props: ['heading', 'colName'],
  data() {
    return {
      show: false,
      expanded: false,
    };
  },
  methods: {
    colClick() {
      this.$emit('sort', this.colName, this.sortOrder());
      this.expanded = !this.expanded;
    },
    sortOrder() {
      return this.expanded ? 'DESC' : 'ASC';
    },
  },
};
</script>
