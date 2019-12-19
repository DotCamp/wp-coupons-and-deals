<template>
  <tr
    class="wpcd-form-shortcode-generic-transition wpcd-fs-basic-fade"
    @mouseover="mouseOver(true)"
    @mouseout="mouseOver(false)"
  >
    <td>
      <div class="wpcd-fs-bold">
        <span @click="$emit('edit', ID)" class="wpcd-fs-text-blue-500 wpcd-fs-pointer">{{ post_title }}</span>
        <span>{{ post_status === 'publish' ? '' : ('| ' + post_status) | cap }} </span>
      </div>
      <div :style="{ visibility: hover ? 'visible' : 'hidden' }" class="wpcd-fs-text-sm">
        <a class="wpcd-fs-pointer wpcd-fs-text-blue-500" @click="$emit('edit', ID)">Edit</a>
        <span v-if="extras.thrash_enable === 'on'">
          |
          <a class="wpcd-fs-pointer wpcd-fs-text-red-500" @click="$emit('thrash', ID)">Thrash</a>
        </span>
      </div>
    </td>
    <td>
      {{ coupon_type }}
    </td>
    <td>
      {{ renderTerms('category') }}
    </td>
    <td>
      {{ renderTerms('vendor') }}
    </td>
    <td>{{ ID }}</td>
  </tr>
</template>
<script>
export default {
  props: ['post_title', 'post_status', 'coupon_type', 'ID', 'terms'],
  data() {
    return {
      hover: false,
    };
  },
  methods: {
    mouseOver(status) {
      this.hover = status;
    },
    renderTerms(name) {
      if (this.terms[name].length > 0) {
        const tempArray = [];
        this.terms[name].map(t => {
          tempArray.push(t.name);
        });

        return tempArray.join(', ');
      }
      return '---';
    },
  },
};
</script>
